<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class realms_model extends model {
        public function get_realmlist() {
            $query = 'SELECT r.id AS id, r.name AS name, r.address AS address, r.port AS port, r.icon AS type, r.population AS population, r.realmbuilds AS builds, COALESCE(u.starttime, 0) AS started, COALESCE(u.uptime, 0) AS uptime
                      FROM ' . DB_REALMD . '.realmlist r
                      LEFT JOIN ' . DB_REALMD . '.uptime u ON r.id = u.realmid
                      LEFT JOIN (SELECT realmid, MAX(starttime) AS max_starttime FROM ' . DB_REALMD . '.uptime GROUP BY realmid) u2
                      ON u.realmid = u2.realmid AND u.starttime = u2.max_starttime
                      WHERE (u.realmid IS NULL OR (u.realmid IS NOT NULL AND u.starttime = u2.max_starttime))
                      ORDER BY r.id ASC';
			$statement = database::connection()->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$result)
				return array();
			return $result;
        }

        public function get_realm_history($id) {
            $query = 'SELECT r.name AS name, COALESCE(u.starttime, 0) AS started, COALESCE(u.uptime, 0) AS uptime, COALESCE(u.maxplayers, 0) AS players
                      FROM ' . DB_REALMD . '.realmlist r, ' . DB_REALMD . '.uptime u
                      WHERE r.id = u.realmid AND r.id = :id
                      ORDER BY r.id ASC, u.starttime DESC';
			$statement = database::connection()->prepare($query);
			$statement->execute(array('id' => $id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$result)
				return array();
			return $result;
        }

        public function get_players_online_count($realm_id) {
            $statement = database::connection()->prepare('SELECT count(online) AS count FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters WHERE online = 1');
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                return 0;
            else return $result['count'];
        }

        public function get_players_online($realm_id) {
            $statement = database::connection()->prepare('SELECT guid AS id, name, race, class, gender, level, totaltime FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters WHERE online = 1');
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }

        public function get_honor_list($realm_id, $realm_version) {
            $expansion_query = 'SELECT guid AS id, name, race, class, gender, level, totalHonorPoints AS honor, totalKills AS kills FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters WHERE totalHonorPoints > 0 OR totalKills > 0 ORDER BY honor DESC, kills DESC LIMIT ' . REALMS_HONOR_LIMIT;
            $classic_querry = 'SELECT c.guid AS id, c.name AS name, c.race AS race, c.class AS class, c.gender AS gender, c.level AS level, c.stored_honor_rating + COALESCE(SUM(h1.honor), 0) AS honor, c.stored_honorable_kills + COALESCE(COUNT(h1.type), 0) AS honorable_kills, c.stored_dishonorable_kills + COALESCE(COUNT(h2.type), 0) AS dishonorable_kills
                      FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters c
                      LEFT JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.character_honor_cp h1
                      ON c.guid = h1.guid AND h1.victim_type > 0 AND h1.type = 1
                      LEFT JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.character_honor_cp h2
                      ON c.guid = h2.guid AND h2.victim_type > 0 AND h2.type = 2
                      GROUP BY c.guid, c.name, c.race, c.class, c.gender, c.level, c.stored_honor_rating, c.stored_honorable_kills, c.stored_dishonorable_kills
                      HAVING honor > 0 OR honorable_kills > 0
                      ORDER BY honor DESC, honorable_kills DESC
                      LIMIT ' . REALMS_HONOR_LIMIT;

            $statement = database::connection()->prepare(in_array($realm_version, ['tbc', 'wotlk']) ? $expansion_query : $classic_querry);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }

        public function get_guilds_list($realm_id) {
            $statement = database::connection()->prepare('SELECT g.guildid AS id, g.name AS name, FROM_UNIXTIME(g.createdate) AS date, c.name AS leader_name, c.guid AS leader_id, c.race AS leader_race, COUNT(m.guid) AS members FROM ' . DB_MANGOSD[$realm_id]['character'] . '.guild g, ' . DB_MANGOSD[$realm_id]['character'] . '.guild_member m, ' . DB_MANGOSD[$realm_id]['character'] . '.characters c WHERE g.leaderguid = c.guid AND g.guildid = m.guildid GROUP BY g.guildid ORDER BY members DESC');
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }
        
        public function get_guild_details($realm_id, $guild_id) {
            $statement = database::connection()->prepare('SELECT g.guildid AS id, g.name AS name, FROM_UNIXTIME(g.createdate) AS date, c.name AS leader_name, c.guid AS leader_id, c.race AS leader_race, COUNT(m.guid) AS members FROM ' . DB_MANGOSD[$realm_id]['character'] . '.guild g, ' . DB_MANGOSD[$realm_id]['character'] . '.guild_member m, ' . DB_MANGOSD[$realm_id]['character'] . '.characters c WHERE g.leaderguid = c.guid AND g.guildid = m.guildid and g.guildid = :guild_id GROUP BY g.guildid');
			$statement->execute(array('guild_id' => $guild_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result[0];
        }

        public function get_guild_players($realm_id, $guild_id) {
            $statement = database::connection()->prepare('SELECT c.guid AS id, c.name AS name, c.race AS race, c.level AS level, c.class AS class, c.gender AS gender, r.rname AS rank FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters c, ' . DB_MANGOSD[$realm_id]['character'] . '.guild_member m, ' . DB_MANGOSD[$realm_id]['character'] . '.guild_rank r WHERE m.guid = c.guid AND m.guildid = r.guildid AND m.rank = r.rid AND m.guildid = :guild_id');
			$statement->execute(array('guild_id' => $guild_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }
        
        public function get_battlegrounds_list($realm_id, $days) {
            $statement = database::connection()->prepare('SELECT id, winner_team, bracket_id, type, date FROM ' . DB_MANGOSD[$realm_id]['character'] . '.pvpstats_battlegrounds ORDER BY date DESC LIMIT ' . REALMS_BATTLEGROUNDS_LIMIT);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }
        
        public function get_battleground_details($realm_id, $battleground_id) {
            $statement = database::connection()->prepare('SELECT id, winner_team, bracket_id, type, date FROM ' . DB_MANGOSD[$realm_id]['character'] . '.pvpstats_battlegrounds WHERE id = :battleground_id');
			$statement->execute(array('battleground_id' => $battleground_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result[0];
        }
        
        public function get_battleground_players($realm_id, $battleground_id, $realm_version) {
            $statement = database::connection()->prepare('SELECT c.guid AS id, c.name AS name, c.race AS race, c.gender AS gender, c.class AS class, p.score_killing_blows AS kills, p.score_deaths AS deaths, p.score_honorable_kills AS honorable_kills, p.score_bonus_honor AS honor, p.score_damage_done AS damage, p.score_healing_done AS healing FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters c, ' . DB_MANGOSD[$realm_id]['character'] . '.pvpstats_players p WHERE c.guid = p.character_guid AND p.battleground_id = :battleground_id ORDER BY :order_column DESC');
			$statement->execute(array('battleground_id' => $battleground_id, 'order_column' => ($realm_version === 'classic' ? 'kills' : 'damage')));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }

        public function get_character_details($character_id, $realm_id) {
			$statement = database::connection()->prepare('
                SELECT c.guid AS id, c.name AS name, c.race AS race, c.class AS class, c.gender AS gender, c.level AS level, c.xp AS xp, c.money AS money, c.online AS online, c.totaltime AS totaltime, c.map AS map, c.zone AS ZONE, g.guildid AS guild_id, g.name AS guild_name, g3.rname AS guild_rank, c.playerBytes AS playerBytes, c.playerBytes2 AS playerBytes2, s.strength AS strength, s.agility AS agility, s.stamina AS stamina, s.intellect AS intellect, s.spirit AS spirit, s.armor AS armor, s.maxhealth AS health, s.maxpower1 AS mana, s.maxpower2 AS rage, s.maxpower3 AS focus, s.maxpower4 AS energy, s.maxpower6 AS rune, s.maxpower7 AS runic, s.resFire AS fire_resistance, s.resNature AS nature_resistance, s.resFrost AS frost_resistance, s.resShadow AS shadow_resistance, s.resArcane AS arcane_resistance, s.blockPct AS block_chance, s.dodgePct AS dodge_chance, s.parryPct AS parry_chance, s.critPct AS crit_chance, s.rangedCritPct AS ranged_crit_chance, s.attackPower AS attack_power, s.rangedAttackPower AS ranged_attack_power
                FROM ' . DB_MANGOSD[$realm_id]['character'] . '.characters c
                JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.character_stats s ON c.guid = s.guid
                LEFT JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.guild_member g2 ON c.guid = g2.guid
                LEFT JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.guild g ON g.guildid = g2.guildid
                LEFT JOIN ' . DB_MANGOSD[$realm_id]['character'] . '.guild_rank g3 ON g2.rank = g3.rid AND g.guildid = g3.guildid
                WHERE c.guid = :character_id;
            ');
            $statement->execute(array('character_id' => $character_id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$result)
				return array();
			return $result[0];
		}

        public function get_character_items($character_id, $realm_id) {
            $statement = database::connection()->prepare('SELECT a.id AS id, i.slot AS slot, a.slot AS displayslot, a.displayid AS display_id, a.icon AS icon, t.sheath AS sheath, t.quality AS quality FROM ' . DB_MANGOSD[$realm_id]['character'] . '.character_inventory i, ' . DB_MANGOSD[$realm_id]['world'] . '.item_template t, ' . DB_WEBSITE . '.armory_items a WHERE i.bag = 0 AND i.slot < 19 AND i.item_template = a.id AND i.item_template = t.entry AND i.guid = :character_id ORDER BY a.slot, i.guid');
			$statement->execute(array('character_id' => $character_id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$result)
				return array();
			return $result;
        }

        public function get_character_professions($character_id, $realm_id) {
            $statement = database::connection()->prepare('
                SELECT c.skill AS id, a.name AS name, c.value AS value, c.max AS max
                FROM ' . DB_MANGOSD[$realm_id]['character'] . '.character_skills c, ' . DB_WEBSITE . '.armory_skills a
                WHERE c.guid = :character_id AND c.skill = a.id AND a.type IN (9, 11)
                ORDER BY a.type DESC
            ');
			$statement->execute(array('character_id' => $character_id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			if (!$result)
				return array();
			return $result;
        }

        public function get_race_statistics($id) {
            $statement = database::connection()->prepare('SELECT CONCAT(race, \'-\', gender) AS race, COUNT(race) AS count, (SELECT COUNT(*) FROM ' . DB_MANGOSD[$id]['character'] . '.characters) AS total FROM ' . DB_MANGOSD[$id]['character'] . '.characters GROUP BY race, gender');
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }

        public function get_class_statistics($id) {
            $statement = database::connection()->prepare('SELECT class, COUNT(class) AS count, (SELECT COUNT(*) FROM ' . DB_MANGOSD[$id]['character'] . '.characters) AS total FROM ' . DB_MANGOSD[$id]['character'] . '.characters GROUP BY class');
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            else return $result;
        }

        public function get_realm_status($address, $port) {
            return @fsockopen($address, $port, $code, $message, 0.005);
        }
    }
?>