<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class _404_controller extends controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('_404');
            $this->data['authenticated'] = $this->authenticated();
        }

        public function index($parameters) {
			$this->data['title'] = 'Oops...';
			$this->data['banner'] = '/public/img/banner/default.webp';

            $this->load->view('_404', $this->data);
        }
    }
?>