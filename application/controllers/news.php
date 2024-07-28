<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class news_controller extends controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('news');
            $this->data['authenticated'] = $this->authenticated();
        }
        
        public function latest($parameters) {
			$this->data['title'] = 'Latest News';
			$this->data['banner'] = '/public/img/banner/default.webp';

			$this->data['latest_news'] = $this->model->get_latest_news();
			
			$this->load->view('news/latest', $this->data);
		}

		public function archived($parameters) {
			$this->data['title'] = 'Archived News';
			$this->data['banner'] = '/public/img/banner/default.webp';

			$this->data['archived_news'] = $this->model->get_archived_news();

			$this->load->view('news/archived', $this->data);
		}
    }
?>