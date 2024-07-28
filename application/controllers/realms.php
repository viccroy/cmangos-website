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
			$this->data['banner'] = '/public/img/banners/default.webp';

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
			$this->data['banner'] = '/public/img/banners/default.webp';

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
			$this->data['banner'] = '/public/img/banners/default.webp';

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

        private function get_realm_type($type) {
            $types = array(
                '0' => 'Normal',
                '1' => '<span style=\'color: red;\'>PvP</span>',
                '4' => 'Normal',
                '6' => '<span style=\'color: green;\'>RP</span>',
                '8' => 'RP PvP'
            );
            return isset($types[$type]) ? $types[$type] : 'Unknown';
        }

        private function get_population($population, $players) {
            if($population > 1.0)
                return '<span style=\'color: red;margin-right: 4px;\'>High</span> (' . $players . ')';
            if($population > 0.5)
                return '<span style=\'color: orange;margin-right: 4px;\'>Medium</span> (' . $players . ')';
            return '<span style=\'color: green;margin-right: 4px;\'>Low</span> (' . $players . ')';
        }
    }
?>