<?
	/**
	* @package   cmangos-website
	* @version   1.0
	* @author    Viccroy
	* @copyright 2023 Viccroy
	* @link      https://github.com/viccroy/cmangos-website/
	* @license   https://github.com/viccroy/cmangos-website/blob/master/LICENCE.txt Attribution-NonCommercial-NoDerivatives 4.0 International  
	**/
	
    class router {
        private $routes = [];

        public function process() {
            $_request = htmlspecialchars(filter_var(urldecode($_SERVER['REQUEST_URI']), FILTER_SANITIZE_URL), ENT_QUOTES, 'UTF-8');
            $_method = $_SERVER['REQUEST_METHOD'];

            foreach ($this->routes as $route) {
                $pattern = str_replace('/', '\/', $route['path']);
                $pattern = preg_replace('/:(\w+)/', '(?<$1>[^\/]+)', $pattern);
                $pattern = '/^' . $pattern . '\/?$/';
                $parameters = [];

                if (preg_match($pattern, $_request, $matches)) {
                    if (!in_array(strtolower($_method), array_map('strtolower', $route['methods']))) {
                        header('Location: ' . WEBSITE_BASE_URL . '/404');
                        exit();
                    }

                    $handler = explode('@', $route['handler']);
                    $class = !empty($handler[0]) && class_exists($handler[0]) ? $handler[0] : '_404_controller';
                    $instance = new $class();
                    $method = !empty($handler[1]) && method_exists($instance, $handler[1]) ? $handler[1] : 'index';

                    if ($class !== '_404_controller')
                        foreach ($matches as $key => $value)
                            if (!is_numeric($key) && !empty($key) && !empty($value))
                                $parameters[$key] = $value;


                    return call_user_func_array([$instance, $method], [$parameters]);
                }
            }

            header('Location: ' . WEBSITE_BASE_URL . '/404');
            exit();
        }

        public function register(array $methods, string $path, string $handler) {
            $this->routes[] = [
                'path' => $path,
                'methods' => $methods,
                'handler' => $handler
            ];

        }

        public function routes() {
            return $this->routes;
        }
    }
?>