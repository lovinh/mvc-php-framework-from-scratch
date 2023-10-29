<?php

namespace app\core;

use app\core\http_context\Response;
use InvalidArgumentException;

use function app\core\helper\url;

class Route
{
    private $__route_key = null;

    public static $routes = [];

    public static $current_idx = 0;

    public function get_route_key()
    {
        return $this->__route_key;
    }

    public static function get_full_url()
    {
        return url((!empty($_SERVER['PATH_INFO']) ? ltrim($_SERVER['PATH_INFO'], '/') : ""));
    }

    public static function get(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "GET");
    }

    public static function post(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "POST");
    }

    public static function put(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "PUT");
    }

    public static function patch(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "PATCH");
    }

    public static function delete(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "DELETE");
    }

    public static function any(string $uri, $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, "any");
    }

    public static function match(array $method, string $uri, callable $handler)
    {
        $params = self::parse_uri($uri);
        return self::set_route($uri, $handler, $params, $method);
    }

    public static function redirect(string $source_uri, string $destination_uri, $status_code = 302)
    {
        $handler = function ($destination_uri, $status_code) {
            http_response_code($status_code);
            header("Location: " . url(trim($destination_uri, '/')));
            exit;
        };
        return self::set_route($source_uri, $handler, [$destination_uri, $status_code], "NULL");
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

    // Handling method

    public static function handle($url, $method): array
    {

        $returned = [
            "handler" => null,
            "params" => null
        ];

        // Duyệt các route được đăng ký
        foreach (self::$routes as $key => $route) {
            // Tìm kiếm uri match với uri đã đăng ký route

            $mapping_result = self::map_uri($url, $route['uri']);

            if ($mapping_result['is_map']) {
                $params = $mapping_result['params'];

                if ($route['method'] == strtoupper($method)) {
                    $returned['handler'] = $route["handler"];
                    $returned['params'] = $params;
                    return $returned;
                }
                if (is_array($route['method'])) {
                    if (in_array(strtoupper($method), $route['method'])) {
                        $returned['handler'] = $route["handler"];
                        $returned['params'] = $params;
                        return $returned;
                    }
                }
                if ($route['method'] == "ANY") {
                    $returned['handler'] = $route["handler"];
                    $returned['params'] = $params;
                    return $returned;
                }
                if ($route['method'] == "NULL") {
                    $returned['handler'] = $route["handler"];
                    $returned['params'] = $params;
                    return $returned;
                }
                continue;
            }
        }

        self::abort();
    }

    private static function map_uri(string $url, string $uri)
    {
        $exploded_uri = explode('/', $uri);
        $exploded_url = explode('/', $url);
        $returned = [
            "is_map" => true,
            "params" => []
        ];
        foreach ($exploded_uri as $key => $value) {
            if (preg_match('~{\s*(.+?)\s*}~is', $value) && !empty($exploded_url[$key])) {
                continue;
            }
            if ($exploded_url[$key] != $value) {
                $returned['is_map'] = false;
                break;
            }
        }
        if ($returned['is_map']) {
            foreach ($exploded_uri as $key => $value) {
                if (preg_match('~{\s*(.+?)\s*}~is', $value)) {
                    if (!empty($exploded_url[$key]))
                        array_push($returned['params'], $exploded_url[$key]);
                }
            }
        }
        return $returned;
    }

    private static function parse_uri($uri)
    {
        $params = [];
        $exploded_uri = explode('/', $uri);
        foreach ($exploded_uri as $key => $value) {
            if (preg_match('~{\s*(.+?)\s*}~is', $value, $match)) {
                $params[$match[1]] = $key;
            }
        }
        return $params;
    }

    private static function set_route(string $uri, $handler, array $params, string|array $method)
    {
        $is_method_array = false;
        if (is_array($method)) {
            foreach ($method as $key => $value) {
                self::validate_allowed_method(strtoupper($value));
                $method[$key] = strtoupper($value);
            }
            $is_method_array = true;
        } else {
            self::validate_allowed_method(strtoupper($method));
        }
        self::$routes[self::$current_idx] = [
            "uri" => $uri,
            "handler" => $handler,
            "params" => $params,
            "method" => $is_method_array ? $method : strtoupper($method),
            "middleware" => null
        ];
        self::$current_idx += 1;
        return new self();
    }

    private static function abort(int $status_code = 404)
    {
        http_response_code($status_code);
        die();
    }

    // validate
    private static function validate_allowed_method(string $inp)
    {
        $validated_array = array("GET", "POST", "PUT", "PATCH", "DELETE", "ANY", "NULL");
        if (!in_array($inp, $validated_array, true)) {
            throw new InvalidArgumentException("ROUTE INVALID REQUEST METHOD: Request method '$inp' không hợp lệ! Giá trị hợp lệ bao gồm: " . '"GET", "POST", "PUT", "PATCH", "DELETE", "ANY"');
        }
    }

    // Deprecated function
    /**
     * @deprecated
     */
    public static function run($url)
    {
        // $url = trim($url, '/');
        if (!empty(self::$routes)) {
            foreach (self::$routes as $key => $value) {
                if (preg_match("~" . $value['uri'] . "~is", $url)) {
                    $url = preg_replace("~" . $value['uri'] . "~is", $value['handler'], $url);
                    break;
                }
            }
            return $url;
        }
    }

    /**
     * @deprecated
     */
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
}
