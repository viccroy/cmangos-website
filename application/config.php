<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/

	define('WEBSITE_TITLE', 'cMaNGOS');
	define('WEBSITE_DOMAIN', '127.0.0.1');
	define('WEBSITE_HTTPS', false);
	define('WEBSITE_BASE_URL', sprintf('http%s://%s', WEBSITE_HTTPS ? 's' : '', WEBSITE_DOMAIN));
	define('WEBSITE_TIMEZONE', 'Europe/Bucharest');

	// This is where you configure your landing page.
	define('DEFAULT_CONTROLLER', 'news');
	define('DEFAULT_METHOD', 'latest');

	// Whether to display the site disclaimer or not. Disable at your own discretion/peril.
	define('WEBSITE_DISCLAIMER', true);
	define('NEWS_SPOTLIGHT_AVATAR', true);
	define('NEWS_ARCHIVE_AFTER_DAYS', 28);
	define('ACCOUNT_ACCESS_LOGS_DAYS', 7);
	define('REALMS_BATTLEGROUNDS_DAYS', 7);
	define('REALMS_BATTLEGROUNDS_LIMIT', 50);
	define('REALMS_HONOR_LIMIT', 50);
	define('REALMS_ARMORY_ENABLED', false);
	// This will not work without the 3rd party SMTP relay configuration.
	define('REQUIRE_ACCOUNT_ACTIVATION', false);

	// This is where you define the default avatar & signature code as well as the list of available avatars & signatures.
	define('DEFAULT_AVATAR', 'default');
	define('DEFAULT_SIGNATURE', 'default');
	define('AVATAR_LIST', [
		'default', 'aiternia', 'alarm_bot', 'arcane_elemental', 'aredek', 'ashbringer', 'balanar', 'baltrosk', 'bear_cub', 'blood_elf',
		'broom_cat', 'cat_form_dancing', 'centaur', 'core_hound', 'corrupted_blood_elf', 'cosmos', 'dancing_murloc', 'dancing_tauren', 'demon',
		'devilsaur', 'dragonkin', 'drake', 'dwarf_lord', 'dwarf_minigun', 'elemental', 'energy_pulse', 'enraged_orc', 'essence',
		'fangtooth', 'fire_elemental', 'floating_candle', 'furbolg', 'ghostcrawler', 'gnoll', 'gnome', 'gnome_blacksmith', 'gnome_engineer',
		'gnome_technician', 'goblin', 'gorilla', 'gryphon', 'halloween_pumpkin', 'hearthstone', 'human_assassin', 'imp', 'innkeeper',
		'lava_elemental', 'lich', 'moonkin', 'nerubian', 'orc', 'panda', 'phoenix', 'pirate', 'rock_elemental',
		'running_murloc', 'shadow', 'sheep', 'silithid', 'sleeping_panda', 'snowman', 'spirit_healer', 'squirrel',
		'tauren', 'toxic_slime', 'treant', 'turtle', 'undead_channeling', 'water_elemental', 'welp', 'wisp', 'worgen']);
	define('SIGNATURE_LIST', [
		'default', 'ahn_qiraj', 'atal_hakkar', 'auchindoun', 'azjol_nerub', 'black_temple', 'blackfathom_deeps', 'blackrock_depths',
		'blackrock_spire', 'blackwing_lair', 'coilfang_reservoir', 'dalaran_arena', 'deadmines', 'dire_maul', 'gnomeregan', 'gundrak',
		'hellfire_citadel', 'icecrown_citadel', 'karazhan', 'maraudon', 'molten_core', 'mount_hyjal', 'naxxramas', 'obsidian_sanctum',
		'razorfen_downs', 'razorfen_kraul', 'ruby_sanctum', 'scarlet_monastery', 'scholomance', 'shadowfang_keep', 'stockade', 'stratholme',
		'tempest_keep', 'tharon_keep', 'the_nexus', 'the_oculus', 'uldaman', 'ulduar', 'utgarde_keep', 'utgarde_pinnacle',
		'violet_hold', 'wailing_caverns', 'warsong_gulch', 'zul_aman', 'zul_farrak', 'zul_gurub'
	]);
	
	// This setting controlls which uptimes and how long before they are removed from the database.
	define('MANGOSD_UPTIME_CLEAR', 60*60);
	 // This setting controlls which uptimes and how long before they are removed from the database.
	define('MANGOSD_UPTIME_HISTORY_CLEAR', 60*60*24*7);
	define('MANGOSD_SHOW_UPTIME_HISTORY', true);

	// Database credentials
	define('DB_HOST', '127.0.0.1');
	define('DB_PORT', '3306');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'root');
	define('DB_WEBSITE', 'website');
	// This is your main realmd. All your realms MUST use the same realmd database. Read the CMaNGOS documentation on how to configure your realms to use a single account.
	define('DB_REALMD', 'realmd');
	// This maps to the ids of the realms specified in the DB_REALMD.realmlist table.
	define('DB_MANGOSD', array(
		1 => array(
			// This is to avoid a DNS lookup (if the server is hosted on the same machine) every time we check for realm status (even if it's cached).
			'address' => '127.0.0.1',
			// World and character databases of the realm
			'world' => 'mangosd_classic',
			'character' => 'characters_classic'
		),
		2 => array(
			// This is to avoid a DNS lookup (if the server is hosted on the same machine) every time we check for realm status (even if it's cached).
			'address' => '127.0.0.1',
			// World and character databases of the realm
			'world' => 'mangosd_tbc',
			'character' => 'characters_tbc'
		),
		3 => array(
			// This is to avoid a DNS lookup (if the server is hosted on the same machine) every time we check for realm status (even if it's cached).
			'address' => '127.0.0.1',
			// World and character databases of the realm
			'world' => 'mangosd_wotlk',
			'character' => 'characters_wotlk'
		),
	));
	
	define('COOKIE_PATH', '/');
	define('COOKIE_NAME', 'CREDENTIALS');
	define('COOKIE_TIMEOUT', 60*60*24*7);
	define('COOKIE_ENCRYPTION', true);
	define('COOKIE_ENCRYPTION_KEY', ''); // CONFIGURE THIS BEFORE YOU PUBLISH YOUR WEBSITE. CHANGING IT AFTER LOGS EVERY PLAYER OUT OF THEIR ACCOUNT.
	define('COOKIE_SIGNING_KEY', ''); // CONFIGURE THIS BEFORE YOU PUBLISH YOUR WEBSITE. CHANGING IT AFTER LOGS EVERY PLAYER OUT OF THEIR ACCOUNT.

	// DO NOT TOUCH THIS IF YOU HAVE NO IDEA HOW MFA-TOTP WORKS!
	// ONCE YOU LAUNCH YOUR WEBSITE, DO NOT (UNDER ANY CIRCUMSTANCES) CHANGE THESE VALUES. IF YOU DO, ALL ACCOUNTS WITH MFA ENABLED WILL NO LONGER BE ABLE TO AUTHENTICATE!
	define('OTP_SECRET_LENGTH', '16');
	define('OTP_TOKEN_LENGTH', '6');
	define('OTP_RECOVERY_TOKENS', '12');
	define('OTP_TOKEN_TIMEWINDOW', '1');
	define('OTP_TOKEN_TIMESTEP', '30');
	define('OTP_TOKEN_CEILING', '1000000');

	// THIS IS THE CONFIGURATION FOR THE 3RD PARTY SMTP RELAY (USUALLY ISSUED BY YOUR DOMAIN NAME REGISTRAR)
	define('SMTP_HOST', '');
	define('SMTP_PORT', 587);
	define('SMTP_USERNAME', '');
	define('SMTP_PASSWORD', '');
?>