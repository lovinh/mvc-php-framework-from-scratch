<?php

namespace app\core;
use function app\core\helper\url;

class Route
{
    private $__route_key = null;

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


    public function get(string $uri, $handler)
    {
        echo $uri;
    }

    public function run()
    {
    }
}
