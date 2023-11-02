<?php

namespace app\core;

use app\core\http_context\Request;
use app\core\http_context\Response;
use app\core\middleware\BaseMiddleware;
use InvalidArgumentException;

use function app\core\helper\url;

class Route
{
    private $__route_key = null;

    public static $routes = [];

    public static $current_idx = 0;

    public static $mapping_name_idx = [];

    private static $fallback = null;

    private static $route_middleware = null;

    public static function get_full_url()
    {
        return url((!empty($_SERVER['PATH_INFO']) ? ltrim($_SERVER['PATH_INFO'], '/') : ""));
    }

    /**
     * Đăng ký route cho request có phương thức GET.
     * @param string $uri Đường dẫn tài nguyên của request
     * @param mixed $handler callable object. Trình xử lý khi route gặp request phù hợp.
     */
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
        $handler = function () use ($destination_uri, $status_code) {
            http_response_code($status_code);
            header("Location: " . url(trim($destination_uri, '/')));
            exit;
        };
        return self::set_route($source_uri, $handler, [], "NULL");
    }

    /**
     * Route xử lý khi không tìm thấy bất kỳ route nào có thể xử lý được request. Lưu ý: Route này luôn phải được gọi cuối cùng trong dãy đăng ký route.
     * @param mixed $handle Hàm xử lý của route fallback khi không tìm thấy route nào thỏa mãn xử lý request.
     */
    public static function fallback($handler)
    {
        self::$fallback = $handler;
    }

    public static function name(string $name)
    {
        if (isset(self::$mapping_name_idx[$name])) {
            throw new InvalidArgumentException("INVALID ROUTE NAME: Tên route '$name' đã được định nghĩa cho route index '" . self::$mapping_name_idx[$name] . "'. Vui lòng chọn tên khác cho route này (Index hiện tại: " . self::$current_idx . ")");
        }
        self::$mapping_name_idx[$name] = self::$current_idx - 1;
        return new self();
    }

    public static function where(string $param_name, string $regex_pattern)
    {
        if (empty($param_name)) {
            throw new InvalidArgumentException("ROUTE INVALID PARAM NAME: Tên của param request không được để trống!");
        }
        if (empty($regex_pattern)) {
            throw new InvalidArgumentException("ROUTE INVALID REGEX PATTERN: Biểu thức chính quy không được để trống!");
        }
        if (empty(self::$routes[self::$current_idx - 1]["params"])) {
            return new self();
        }
        if (!array_key_exists($param_name, self::$routes[self::$current_idx - 1]["params"])) {
            throw new InvalidArgumentException("ROUTE INVALID PARAM NAME: Tên của param request không tồn tại!");
        }
        self::$routes[self::$current_idx - 1]["params"][$param_name] = $regex_pattern;
        return new self();
    }

    public static function where_in(string $param_name, array $item_list)
    {
        if (empty($param_name)) {
            throw new InvalidArgumentException("ROUTE INVALID PARAM NAME: Tên của param request không được để trống!");
        }
        if (empty($item_list)) {
            throw new InvalidArgumentException("ROUTE INVALID ITEM LIST: Danh sách phần tử không được để trống!");
        }
        if (empty(self::$routes[self::$current_idx - 1]["params"])) {
            return new self();
        }
        if (!array_key_exists($param_name, self::$routes[self::$current_idx - 1]["params"])) {
            throw new InvalidArgumentException("ROUTE INVALID PARAM NAME: Tên của param request không tồn tại!");
        }
        self::$routes[self::$current_idx - 1]["params"][$param_name] = implode('|', $item_list);
        return new self();
    }

    public static function group()
    {
    }

    public static function middleware(string|array $middleware_class)
    {
        if (empty($middleware_class)) {
            throw new InvalidArgumentException("ROUTE INVALID MIDDLEWARE CLASS: Tên middlewares class không được để trống!");
        }
        if (!is_array($middleware_class)) {
            $middleware_class = array($middleware_class);
        }
        if (is_array($middleware_class) && empty($middleware_class)) {
            throw new InvalidArgumentException("ROUTE INVALID MIDDLEWARE CLASS: Mảng middlewares class không được để trống!");
        }
        $init_middleware_class = [];
        foreach ($middleware_class as $key => $value) {
            $init_middleware_class[$value] = new $value();
        }
        self::$routes[self::$current_idx - 1]['middleware'] = $init_middleware_class;
    }

    // Handling method

    public static function handle(Request $request): array
    {
        $url = $request->path();
        $method = $request->get_method();
        self::$route_middleware = new BaseMiddleware();
        $setup = function ($route, $params) {
            $returned = [
                "handler" => null,
                "params" => null
            ];
            $returned['handler'] = $route["handler"];
            $returned['params'] = $params;
            return $returned;
        };
        // Duyệt các route được đăng ký
        foreach (self::$routes as $key => $route) {

            // Tìm kiếm uri match với uri đã đăng ký route
            $mapping_result = self::map_uri($url, $route['uri'], $route['params']);

            if (!$mapping_result['is_map'])
                continue;

            // Xử lý route middleware
            self::$route_middleware->clear();

            if (!empty($route['middleware'])) {
                foreach ($route['middleware'] as $middleware) {
                    self::$route_middleware->add(new $middleware());
                }

                self::$route_middleware->run($request);
            }

            $params = $mapping_result['params'];

            if ($route['method'] == strtoupper($method)) {
                return $setup($route, $params);
            }
            if (is_array($route['method'])) {
                if (in_array(strtoupper($method), $route['method'])) {
                    return $setup($route, $params);
                }
            }
            if ($route['method'] == "ANY") {
                return $setup($route, $params);
            }
            if ($route['method'] == "NULL") {
                return $setup($route, $params);
            }
            continue;
        }

        if (empty(self::$fallback)) {
            self::abort();
        } else {
            $route = [
                "handler" => self::$fallback
            ];
            return $setup($route, []);
        }
    }

    // Helper method

    private static function map_uri(string $url, string $uri, $validated_params = [])
    {
        $exploded_uri = explode('/', $uri);
        $exploded_url = explode('/', $url);
        $returned = [
            "is_map" => true,
            "params" => []
        ];
        if (count($exploded_uri) != count($exploded_url)) {
            $returned["is_map"] = false;
            return $returned;
        }
        for ($i = 0; $i <= count($exploded_uri) - 1; $i++) {
            if (preg_match('~{\s*(.+?)\s*}~is', $exploded_uri[$i], $match) && !empty($exploded_url[$i])) {
                if (!empty($validated_params[$match[1]]) && !preg_match('~' . $validated_params[$match[1]] . '~s', $exploded_url[$i])) {
                    $returned["is_map"] = false;
                    return $returned;
                }
                continue;
            }
            if ($exploded_url[$i] != $exploded_uri[$i]) {
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
                $params[$match[1]] = null;
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
