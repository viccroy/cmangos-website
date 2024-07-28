<?
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class controller {
        private static $instance;
        public $load, $input, $model;
        public $data = array(
            'values' => array(),
            'errors' => array()
        );

        public function __construct() {
            self::$instance = $this;
            $this->load = new loader();
            $this->input = new input();
        }

        public static function instance() {
            return self::$instance;
        }

        public function errors() {
            return count(array_filter($this->data['errors'], function ($value) { return $value !== false; }));
        }

        public function add_error($field, $error) {
            if (is_array($this->data['errors']))
                $this->data['errors'] = array_merge($this->data['errors'], array($field => $error));
            else $this->data['errors'] = array($field => $error);
        }
        public function get_errors() {
            if (isset($this->data['errors']))
                return $this->data['errors'];
            else return array();
        }

        public function index($parameters) {
			$this->redirect('/404');
        }

        public function redirect($path) {
            header('Location: ' . $path);
            exit();
        }

        public function get_version($builds) {
            if ($builds === NULL)
                return array('browser', 'Browser');
            if ($builds === '0')
                return array('login', 'Login');
            if (strpos($builds, '12340') !== false)
                return array('wotlk', 'Wrath of the Lich King');
            if (strpos($builds, '8606') !== false)
                return array('tbc', 'The Burning Crusade');
            return array('classic', 'Classic');
        }

        public function get_faction($race) {
            return in_array($race, [1, 3, 4, 7, 11]) ? 'Alliance' : 'Horde';
        }

        public function get_rank_name($faction, $rank) {
            if (lcfirst($faction) === 'alliance') {
                $ranks = array(
                    '1' => 'Private',
                    '2' => 'Corporal',
                    '3' => 'Sergeant',
                    '4' => 'Master Sergeant',
                    '5' => 'Sergeant Major',
                    '6' => 'Knight',
                    '7' => 'Knight-Lieutenant',
                    '8' => 'Knight-Captain',
                    '9' => 'Knight-Champion',
                    '10' => 'Lieutenant Commander',
                    '11' => 'Commander',
                    '12' => 'Marshal',
                    '13' => 'Field Marshal',
                    '14' => 'Grand Marshal'
                );
            } else {
                $ranks = array(
                    '1' => 'Scout',
                    '2' => 'Grunt',
                    '3' => 'Sergeant',
                    '4' => 'Senior Sergeant',
                    '5' => 'First Sergeant',
                    '6' => 'Stone Guard',
                    '7' => 'Blood Guard',
                    '8' => 'Legionnaire',
                    '9' => 'Centurion',
                    '10' => 'Champion',
                    '11' => 'Lieutenant General',
                    '12' => 'General',
                    '13' => 'Warlord',
                    '14' => 'High Warlord'
                );
            }
            return isset($ranks[$rank]) ? $ranks[$rank] : 'Unknown';
        }

        public function get_character_slots($class) {
            return array(
                0 => 'head',
                1 => 'neck',
                2 => 'shoulders',
                3 => 'shirt',
                4 => 'chest',
                5 => 'waist',
                6 => 'legs',
                7 => 'feet',
                8 => 'wrists',
                9 => 'hands',
                10 => 'finger1',
                11 => 'finger2',
                12 => 'trinket1',
                13 => 'trinket2',
                14 => 'back',
                15 => 'main_hand',
                16 => 'off_hand',
                17 => in_array($class, [2, 7, 11]) ? 'relic' : 'ranged',
                18 => 'tabard',
            );
        }

        public function get_hidden_slots() {
            return array(1, 10, 11, 12, 13, 17);
        }

        public function get_race_name($race) {
            $races = array(
                '1' => 'Human',
                '2' => 'Orc',
                '3' => 'Dwarf',
                '4' => 'Night Elf',
                '5' => 'Undead',
                '6' => 'Tauren',
                '7' => 'Gnome',
                '8' => 'Troll',
                '10' => 'Blood Elf',
                '11' => 'Draenei'
            );
            return isset($races[$race]) ? $races[$race] : 'Unknown';
        }

        public function get_race_position($race) {
            $races = array(
                '1' => array(6.25, 0, 0.1, 0),
                '2' => array(7.25, 0, 0.1, 0),
                '3' => array(5.75, 0, 0, 0),
                '4' => array(7.25, 0, 0.05, 0),
                '5' => array(6.25, 0, 0.1, 0),
                '6' => array(7.25, 0, 0.1, 0),
                '7' => array(5.75, 0, 0.1, 0),
                '8' => array(7.25, 0, 0, 0),
                '10' => array(6.25, 0, 0, 0),
                '11' => array(7.25, 0, 0, 0)
            );
            return isset($races[$race]) ? $races[$race] : array(6.25, 0, 0, 0);
        }

        public function get_class_name($class) {
            $classes = array(
                '1' => 'Warrior',
                '2' => 'Paladin',
                '3' => 'Hunter',
                '4' => 'Rogue',
                '5' => 'Priest',
                '6' => 'Death Knight',
                '7' => 'Shaman',
                '8' => 'Mage',
                '9' => 'Warlock',
                '11' => 'Druid'
            );
            return isset($classes[$class]) ? $classes[$class] : 'Unknown';
        }

        public function get_available_races($builds) {
            $races = array('1-0', '1-1', '2-0', '2-1', '3-0', '3-1', '4-0', '4-1', '5-0', '5-1', '6-0', '6-1', '7-0', '7-1', '8-0', '8-1');
            if (strpos($builds, '12340') !== false || strpos($builds, '8606') !== false)
                $races = array_merge($races, array('10-0', '10-1', '11-0', '11-1'));
            return $races;
        }

        public function get_available_classes($builds) {
            $classes = array('1', '2', '3', '4', '5', '7', '8', '9', '11');
            if (strpos($builds, '12340') !== false)
                $classes = array_merge($classes, array('6'));
            return $classes;
        }

        public function get_uptime($uptime, $started, $history = false) {
            if (!$history)
                $uptime = $uptime > 0 ? $uptime : time() - $started;
            $days = floor($uptime/(24*3600));
            $uptime -= $days*(24*3600);
            $hours = floor($uptime/3600);
            $uptime -= $hours*3600;
            $minutes = floor($uptime/60);

            return $days.'d '.$hours.'h '.$minutes.'m';
        }

        public function get_money($money) {
            $gold = floor($money/10000);
            $money -= $gold*10000;
            $silver = floor($money/100);
            $money -= $silver*100;
            $copper = $money;

            return array(
                'gold' => $gold,
                'silver' => $silver,
                'copper' => $copper
            );
        }

        public function authenticated() {
            // Database cleanup.
            $this->model->remove_invalid_uptime();
            $this->model->remove_inactive_accounts();
            $this->model->remove_expired_tokens();
            $this->model->remove_stored_interface_data();

            if (!isset($_COOKIE[COOKIE_NAME])) {
                return false;
            }
            
            list($id, $username, $ip) = jwt::verify_token($_COOKIE[COOKIE_NAME]);
            if (!isset($id) || !isset($username) || !isset($ip) || $ip !== $_SERVER['REMOTE_ADDR']) {
                $cookie_result = setcookie(COOKIE_NAME, '', time() - COOKIE_TIMEOUT, COOKIE_PATH, WEBSITE_DOMAIN, true, true);
                unset($_COOKIE[COOKIE_NAME]);
                return false;
            }
            
            list($salt, $verifier, $secret, $tokens, $locked, $banned) = $this->model->get_login($username);
            if((isset($locked) && $locked) || (isset($banned) && $banned > 0)) {
                setcookie(COOKIE_NAME, '', time() - COOKIE_TIMEOUT, COOKIE_PATH, WEBSITE_DOMAIN, true, true);
                unset($_COOKIE[COOKIE_NAME]);
                return false;
            }

			$this->model->set_user_address($username, $_SERVER['REMOTE_ADDR']);
            return array('id' => $id, 'username' => $username);
        }
    }
?>