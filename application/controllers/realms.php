<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class realms_controller extends controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('realms');
            $this->data['authenticated'] = $this->authenticated();
        }
        
        public function status($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Status';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('name', 'type', 'population', 'players', 'status', 'uptime', 'version', 'history');
                    $realm['status'] = $this->model->get_realm_status(DB_MANGOSD[$realm['id']]['address'], $realm['port']) ? true : false;
                    $realm['type'] = $this->get_realm_type($realm['type']);
                    $realm['players'] = $realm['status'] ? $this->model->get_players_online_count($realm['id']) : '-';
                    $realm['population'] = $this->get_population($realm['population'], $realm['players']);
                    $realm['status'] = $realm['status'] ? 'online' : 'offline';
                    $realm['uptime'] = $realm['status'] == 'online' ? $this->get_uptime($realm['uptime'], $realm['started']) : '-';
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['history'] = $this->model->get_realm_history($realm['id']);

                    if (count($realm['history']) > 0) {
                        $h_keep = array('name', 'players', 'started', 'uptime');
                        foreach ($realm['history'] as &$history) {
                            $history['started'] = date("d-m-y H:i", $history['started']);
                            $history['uptime'] = $this->get_uptime($history['uptime'], $history['started'], true);
                        }
                        $history = array_intersect_key($history, array_flip($h_keep));
                        unset($history);
                    }

                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }

            $this->data['realms'] = $realms;
			$this->load->view('realms/status', $this->data);
		}

        public function players($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Players';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('id', 'name', 'version', 'players');
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['players'] = $this->model->get_players_online($realm['id']);
                    foreach ($realm['players'] as &$player) {
                        $player['faction'] = $this->get_faction($player['race']);
                        $player['race_name'] = $this->get_race_name($player['race']);
                        $player['class_name'] = $this->get_class_name($player['class']);
                        $player['playtime'] = $this->get_uptime($player['totaltime'], 0, true);
                    }
                    unset($player);
                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }
            
            $this->data['realms'] = $realms;
			$this->load->view('realms/players', $this->data);
        }

        public function statistics($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Statistics';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('id', 'name', 'version', 'statistics');
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['statistics']['available_races'] = $this->get_available_races($realm['builds']);
                    $realm['statistics']['available_classes'] = $this->get_available_classes($realm['builds']);

                    $statistics = array();
                    $total = 0;
                    foreach ($this->model->get_race_statistics($realm['id']) as $stats) {
                        $total = $total < $stats['total'] ? $stats['total'] : $total;
                        $statistics[$stats['race']] = array(
                            'count' => $stats['count'],
                            'total' => $stats['total'],
                            'percentage' => round($stats['count'] / $total * 100, 2)
                        );
                    }

                    foreach ($realm['statistics']['available_races'] as $race) {
                        $realm['statistics']['races'][$race] = array(
                            'name' => $this->get_race_name(explode('-', $race)[0]) . ' • ' . (explode('-', $race)[1] ? 'Female' : 'Male'),
                            'count' => array_key_exists($race, $statistics) ? $statistics[$race]['count'] : 0,
                            'total' => $total,
                            'percentage' => array_key_exists($race, $statistics) ? $statistics[$race]['percentage'] : 0
                        );
                    }
                    unset($race);

                    $statistics = array();
                    $total = 0;
                    foreach ($this->model->get_class_statistics($realm['id']) as $stats) {
                        $total = $total < $stats['total'] ? $stats['total'] : $total;
                        $statistics[$stats['class']] = array(
                            'count' => $stats['count'],
                            'total' => $stats['total'],
                            'percentage' => round($stats['count'] / $total * 100, 2)
                        );
                    }

                    foreach ($realm['statistics']['available_classes'] as $class) {
                        $realm['statistics']['classes'][$class] = array(
                            'name' => $this->get_class_name($class),
                            'count' => array_key_exists($class, $statistics) ? $statistics[$class]['count'] : 0,
                            'total' => $total,
                            'percentage' => array_key_exists($class, $statistics) ? $statistics[$class]['percentage'] : 0
                        );
                    }
                    unset($class);

                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }

            $this->data['realms'] = $realms;
			$this->load->view('realms/statistics', $this->data);
        }

        public function honor_list($parameters) {
            $this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Honor';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('id', 'name', 'version', 'players');
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['players'] = $this->model->get_honor_list($realm['id'], $realm['version'][0]);
                    foreach ($realm['players'] as &$player) {
                        $player['faction'] = $this->get_faction($player['race']);
                        $player['race_name'] = $this->get_race_name($player['race']);
                        $player['class_name'] = $this->get_class_name($player['class']);
                    }
                    unset($player);
                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }
            
            $this->data['realms'] = $realms;
			$this->load->view('realms/honor', $this->data);
        }

        public function guilds_list($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Guilds';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('id', 'name', 'version', 'guilds');
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['guilds'] = $this->model->get_guilds_list($realm['id']);
                    foreach ($realm['guilds'] as &$guild) {
                        $guild['faction'] = $this->get_faction($guild['leader_race']);
                    }
                    unset($guild);
                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }

            $this->data['realms'] = $realms;
            $this->load->view('realms/guilds/list', $this->data);
        }

        public function guilds_details($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Guilds';
			$this->data['banner'] = '/public/img/banner/default.webp';

            if (!isset($parameters['realm_id']) ||
                !isset($parameters['guild_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['realm_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['guild_id']) ||
                !array_key_exists($parameters['realm_id'], DB_MANGOSD))
                $this->redirect('/realms/guilds');

            $realms = $this->model->get_realmlist();
            $realm = array_values(array_filter($realms, function ($realm) use ($parameters) {
                return $realm['id'] === $parameters['realm_id'];
            }))[0];

            $realm['version'] = $this->get_version($realm['builds']);
            $keep = array('id', 'name', 'version');
            $this->data['realm'] = array_intersect_key($realm, array_flip($keep));

            $guild = $this->model->get_guild_details($parameters['realm_id'], $parameters['guild_id']);
            if(!$guild)
                $this->redirect('/realms/guilds');

            $this->data['guild'] = $guild;
            $this->data['players'] = $this->model->get_guild_players($parameters['realm_id'], $parameters['guild_id']);
            foreach ($this->data['players'] as &$player) {
                $player['faction'] = $this->get_faction($player['race']);
                $player['race_name'] = $this->get_race_name($player['race']);
                $player['class_name'] = $this->get_class_name($player['class']);
            }
            unset($realms, $realm, $player, $guild);

            $this->load->view('realms/guilds/details', $this->data);
        }

        public function battlegrounds_list($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Battlegrounds';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $realms = $this->model->get_realmlist();
            if (count($realms) > 0) {
                foreach ($realms as &$realm) {
                    $keep = array('id', 'name', 'version', 'battlegrounds');
                    $realm['version'] = $this->get_version($realm['builds']);
                    $realm['battlegrounds'] = $this->model->get_battlegrounds_list($realm['id'], REALMS_BATTLEGROUNDS_DAYS);
                    foreach ($realm['battlegrounds'] as &$battleground) {
                        $battleground['type'] = $this->get_battleground_name($battleground['type'])[0];
                        $battleground['bracket'] = $this->get_battleground_bracket($battleground['bracket_id'], $realm['builds']);
                        $battleground['winner'] = $this->get_battleground_team($battleground['winner_team']);
                    }
                    unset($battleground);
                    $realm = array_intersect_key($realm, array_flip($keep));
                }
                unset($realm);
            }

            $this->data['realms'] = $realms;
            $this->load->view('realms/battlegrounds/list', $this->data);
        }

        public function battlegrounds_details($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Battlegrounds';
			$this->data['banner'] = '/public/img/banner/default.webp';

            if (!isset($parameters['realm_id']) ||
                !isset($parameters['battleground_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['realm_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['battleground_id']) ||
                !array_key_exists($parameters['realm_id'], DB_MANGOSD))
                $this->redirect('/404');

            $realms = $this->model->get_realmlist();
            $realm = array_values(array_filter($realms, function ($realm) use ($parameters) {
                return $realm['id'] === $parameters['realm_id'];
            }))[0];

            $realm['version'] = $this->get_version($realm['builds']);
            $keep = array('id', 'name', 'version');
            $this->data['realm'] = array_intersect_key($realm, array_flip($keep));

            $battleground = $this->model->get_battleground_details($parameters['realm_id'], $parameters['battleground_id']);
            if (!$battleground)
                $this->redirect('/404');

            $battleground['type'] = $this->get_battleground_name($battleground['type'])[0];
            $battleground['bracket'] = $this->get_battleground_bracket($battleground['bracket_id'], $realm['builds']);
            $battleground['winner'] = $this->get_battleground_team($battleground['winner_team']);

            $keep = array('id', 'type', 'bracket', 'winner', 'date');
            $this->data['battleground'] = array_intersect_key($battleground, array_flip($keep));

            $this->data['players'] = $this->model->get_battleground_players($parameters['realm_id'], $parameters['battleground_id'], $realm['version'][0]);
            foreach ($this->data['players'] as &$player) {
                $player['faction'] = $this->get_faction($player['race']);
                $player['race_name'] = $this->get_race_name($player['race']);
                $player['class_name'] = $this->get_class_name($player['class']);
            }
            unset($realms, $realm, $player, $battleground);

            $this->load->view('realms/battlegrounds/details', $this->data);
        }

        public function armory($parameters) {
			$this->data['title'] = 'Realms';
			$this->data['subtitle'] = 'Armory';
			$this->data['banner'] = '/public/img/banner/default.webp';

            if (!isset($parameters['realm_id']) ||
                !isset($parameters['character_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['realm_id']) ||
                !preg_match('/^[0-9]{1,}$/', $parameters['character_id']) ||
                !array_key_exists($parameters['realm_id'], DB_MANGOSD))
                $this->redirect('/');

            $realms = $this->model->get_realmlist();
            $realm = array_values(array_filter($realms, function ($realm) use ($parameters) {
                return $realm['id'] === $parameters['realm_id'];
            }))[0];

            $realm['version'] = $this->get_version($realm['builds']);
            $keep = array('id', 'name', 'version');
            $this->data['realm'] = array_intersect_key($realm, array_flip($keep));

            $this->data['character'] = $this->model->get_character_details($parameters['character_id'], $parameters['realm_id']);
            if(!$this->data['character'])
                $this->redirect('/404');

            $this->data['character']['position'] = $this->get_race_position($this->data['character']['race']);
            $this->data['character']['faction'] = $this->get_faction($this->data['character']['race']);
            $this->data['character']['race_name'] = $this->get_race_name($this->data['character']['race']);
            $this->data['character']['class_name'] = $this->get_class_name($this->data['character']['class']);
            $this->data['character']['skin'] = $this->data['character']['playerBytes'] & 0xFF;
            $this->data['character']['face'] = ($this->data['character']['playerBytes'] >> 8) & 0xFF;
            $this->data['character']['hair_style'] = ($this->data['character']['playerBytes'] >> 16) & 0xFF;
            $this->data['character']['hair_color'] = ($this->data['character']['playerBytes'] >> 24) & 0xFF;
            $this->data['character']['facial_hair'] = $this->data['character']['playerBytes2'] & 0xFF;

            $this->data['character']['professions'] = $this->model->get_character_professions($parameters['character_id'], $parameters['realm_id']);

            $slots = $this->get_character_slots($this->data['character']['class']);
            $items = $this->model->get_character_items($parameters['character_id'], $parameters['realm_id'], $realm['version'][0]);

            foreach ($items as &$item) {
                $item['quality_name'] = $this->get_item_quality_name($item['quality']);
            }

            $this->data['slots'] = array();
            foreach ($slots as $key => $value) {
                $this->data['slots'][$key] = $value;
                $filtered = array_values(array_filter($items, function ($item) use ($key) {
                    return $item['slot'] == $key;
                }));
                $this->data['character']['items'][$key] = !empty($filtered) ? $filtered[0] : null;
            }

            $this->data['character']['sheath'] = array(
                !empty($this->data['character']['items'][15]) ? $this->data['character']['items'][15]['sheath'] : -1,
                !empty($this->data['character']['items'][16]) ? $this->data['character']['items'][16]['sheath'] : -1
            );

            $this->data['character']['models'] = '';
            foreach ($this->data['character']['items'] as $slot => $item) {
                if (!in_array($slot, $this->get_hidden_slots()) && $item['display_id'] && $item['id'] !== '5976') {
                    $this->data['character']['models'] .= (strlen($this->data['character']['models']) > 0 ? ', ' : '') . '[' . $item['displayslot'] . ', ' . $item['display_id'] . ']';
                }
            }
			unset($realms, $realm, $reputation, $slots, $items, $item, $keep);

            $this->load->view('realms/armory', $this->data);
        }

        private function get_realm_type($type) {
            $types = array(
                '0' => '<img src=\'/public/img/icon/pve.webp\' data-tooltip=\'Player vs. Environment\'/>PvE',
                '1' => '<img src=\'/public/img/icon/pvp.webp\' data-tooltip=\'Player vs. Player\'/>PvP',
                '4' => '<img src=\'/public/img/icon/pve.webp\' data-tooltip=\'Player vs. Environment\'/>PvE',
                '6' => '<img src=\'/public/img/icon/rp.webp\' data-tooltip=\'Role-Play\'/>RP',
                '8' => '<img src=\'/public/img/icon/pvp.webp\' data-tooltip=\'Role-Play - Player vs. Player\'/>RP-PvP',
                '16' => '<img src=\'/public/img/icon/pvp.webp\' data-tooltip=\'Free For All - Player vs. Player\'/>FFA-PvP'
            );
            return isset($types[$type]) ? $types[$type] : 'Unknown';
        }

        private function get_population($population, $players) {
            if($population > 1.0)
                return '<span style=\'color: red;margin-right: 5px;\'>High</span> (' . $players . ')';
            if($population > 0.5)
                return '<span style=\'color: orange;margin-right: 5px;\'>Medium</span> (' . $players . ')';
            return '<span style=\'color: green;margin-right: 5px;\'>Low</span> (' . $players . ')';
        }

        private function get_battleground_team($team) {
            $teams = array(
                '0' => 'Horde',
                '1' => 'Alliance'
            );
            return isset($teams[$team]) ? $teams[$team] : 'Draw';
        }

        private function get_battleground_name($battleground) {
            $battlegrounds = array(
                '1' => array('Alterac Valley', 'AV'),
                '2' => array('Warsong Gulch', 'WG'),
                '3' => array('Arathi Basin', 'AB'),
                '7' => array('Eye of the Storm', 'EotS'),
                '9' => array('Strand of the Ancients', 'SotA'),
                '30' => array('Isle of Conquest', 'IoC')
            );
            return isset($battlegrounds[$battleground]) ? $battlegrounds[$battleground] : array('Unknown', 'Unknown');
        }

        private function get_battleground_bracket($bracket_id, $builds) {
            $version = $this->get_version($builds);
            $level_ranges = array(
                '1' => '10-19',
                '2' => '20-29',
                '3' => '30-39',
                '4' => '40-49',
                '5' => '50-59',
                '6' => isset($version) && $version[0] === 'classic' ? '60' : '60-69',
                '7' => isset($version) && $version[0] === 'tbc' ? '70' : '70-79',
                '8' => '80',
            );
            return isset($level_ranges[$bracket_id]) ? $level_ranges[$bracket_id] : 'Unknown';
        }

        public function get_viewer_version($builds) {
            if (strpos($builds, '12340') !== false)
                return 'wotlk';
            return 'wotlk';
        }

        public function get_item_quality_name($quality) {
            $qualities = array(
                0 => 'Poor',
                1 => 'Common',
                2 => 'Uncommon',
                3 => 'Rare',
                4 => 'Epic',
                5 => 'Legendary',
                6 => 'Artifact'
            );
            return isset($qualities[$quality]) ? $qualities[$quality] : 'Poor';
        }
    }
?>