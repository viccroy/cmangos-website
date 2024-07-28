<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class loader {
        public function view($file, $data = null, $indent_tabs = 4) {
            if (is_array($data))
                extract($data);

            ob_start();
            if (file_exists('./application/views/' . $file . '.php'))
                require('./application/views/' . $file . '.php');
            $content = ob_get_clean();
            
            echo $content;
        }

        public function model($file, $name = null) {
            $file .= '_model';
            if ($name) {
                if (!method_exists(controller::instance(), $name))
                    controller::instance()->$name = new $file();
            } else {
                if (!method_exists(controller::instance(), 'model'))
                    controller::instance()->model = new $file();
            }
        }
    }
?>