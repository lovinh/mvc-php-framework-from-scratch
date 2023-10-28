<?php

namespace app\core;

use InvalidArgumentException;

use function app\core\helper\url;

class Route
{
    private $__route_key = null;

    public static $routes = [];

    public static $current_idx = 0;

    public function handle_route($url)
    {
        global $router;
        unset($router["default_controller"]);

        $url = trim($url, '/');

        $handling_url = $url;
        if (!empty($router)) {
            foreach ($router as $key => $value) {
                if (preg_match("~" . $key . "~is", $url)) {
                    $handling_url = preg_replace("~" . $key . "~is", $value, $url);
                    $this->__route_key = $key;
                }
            }
        }

        return $handling_url;
    }

    public function get_route_key()
    {
        return $this->__route_key;
    }

    public static function get_full_url()
    {
        return url((!empty($_SERVER['PATH_INFO']) ? ltrim($_SERVER['PATH_INFO'], '/') : ""));
    }


    public static function get($uri, $handler)
    {
        self::$routes[self::$current_idx] = [
            "uri" => $uri,
            "handler" => $handler,
            "method" => "GET"
        ];
        self::$current_idx += 1;
        return new self();
    }

    public static function name(string $name)
    {
        if (isset(self::$routes[$name])) {
            throw new InvalidArgumentException("INVALID ROUTE NAME: Tên của route đã được định nghĩa. Vui lòng chọn tên khác cho route này");
        }
        self::$routes[$name] = self::$routes[self::$current_idx - 1];
        unset(self::$routes[self::$current_idx - 1]);
        self::$current_idx -= 1;
    }

    public static function run($url)
    {
        // $url = trim($url, '/');
        if (!empty(self::$routes)) {
            foreach (self::$routes as $key => $value) {
                echo '<pre>';
                print_r($value['uri']);
                echo '</pre>';
                if (preg_match("~" . $value['uri'] . "~is", $url)) {
                    $url = preg_replace("~" . $value['uri'] . "~is", $value['handler'], $url);
                    break;
                }
            }
            echo $url;
            return $url;
        }
    }
}
