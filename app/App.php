<?php
class App
{
    private $__controller;
    private $__action;
    private $__parameters;
    private $__route;
    private $__db;

    public static $app;

    function __construct()
    {
        global $router;
        global $app_config;

        // Khởi tạo liên kết đến bản thân đối tượng App
        self::$app = $this;

        // Khởi tạo router

        $this->__route = new Route();

        if (!empty($router["default_controller"])) {
            $this->__controller = $router["default_controller"];
        }
        $this->__action = "index";
        $this->__parameters = [];

        // Khởi tạo trình xử lý và bắt lỗi
        try {
            // Khởi tạo trình xử lý
            $this->init($this->parse_url());
        } catch (Throwable $err) {
            // Bắt lỗi
            $err_code = $err->getCode();
            if ($err_code != 404) {
                $err_code = 500;
            }
            $err_data = [];
            if ($app_config["debug_mode"]) {
                $err_data = [
                    "is_error" => true,
                    "type" => get_class($err),
                    "file" => $err->getFile(),
                    "line" => $err->getLine(),
                    "message" => $err->getMessage(),
                    "trace" => $err->getTrace(),
                    "traceAsString" => $err->getTraceAsString()
                ];
                $this->load_error("debug", $err_data);
            } else {
                $this->load_error($err_code, $err_data);
            }

            die();
        } catch (Exception $ex) {
            // Bắt lỗi
            $err_code = $ex->getCode();
            if ($err_code != 404) {
                $err_code = 500;
            }
            $err_data = [];
            if ($app_config["debug_mode"]) {
                $err_data = [
                    "is_error" => false,
                    "type" => get_class($ex),
                    "message" => $ex->getMessage(),
                    "trace" => $ex->getTrace(),
                    "traceAsString" => $ex->getTraceAsString()
                ];
                $this->load_error("debug", $err_data);
            } else {
                $this->load_error($err_code, $err_data);
            }

            die();
        }
    }

    /**
     * Hàm truy xuất thông tin lớp từ URL.
     */
    function parse_url()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = "/";
        }

        // Xử lý định tuyến (routing handler)
        $url = $this->__route->handle_route($url);

        // This explode() use to seperate a string into substrings by '/' seperator.
        // Example: Home/index/a/b/c/ => ["", "Home", "index", "a", "b", "c", ""]
        // Using array_filter() to remove empty element. From above example, this new array is ["Home", "index", "a", "b", "c"]
        // Using array_value() to reset array index. Now the array start from 0.
        $url_array = array_values(array_filter(explode('/', $url)));

        // Kiểm tra xem đường dẫn có là file hay không
        $url_check = '';
        if (!empty($url_array)) {
            foreach ($url_array as $key => $url_item) {
                $url_check = strtolower($url_check) . ucfirst($url_item) . '/';
                $file_check = rtrim($url_check, '/');
                if (!empty($url_array[$key - 1])) {
                    unset($url_array[$key - 1]);
                }
                if (file_exists("app/controllers/" . $file_check . ".php")) {
                    $url_check = $file_check;
                    break;
                }
            }
            $url_array = array_values($url_array);
        } else {
            $url_check = $this->__controller;
        }

        // Xử lý controller
        if (!empty($url_array[0])) {
            $this->__controller = ucfirst($url_array[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        // Xử lý action
        if (!empty($url_array[1])) {
            $this->__action = ucfirst($url_array[1]);
        } else {
            // placeholder for error handle
        }

        // Xử lý các tham số
        $this->__parameters = array_slice($url_array, 2);

        return $url_check;
    }

    /**
     * Hàm khởi tạo các thông tin từ URL đầu vào.
     * @param string $url_check URL đầu vào.
     */
    function init($url_check)
    {
        // Kiểm tra lớp DB có tồn tại không. Nếu có mới thực hiện khởi tạo đối tượng
        if (class_exists("DB")) {
            $db = new DB();
            $this->__db = $db->get_db();
        }

        // Kiểm tra file controller có tồn tại không
        if (!file_exists("app/controllers/" . $url_check . ".php")) {
            throw new RuntimeException("FILE NOT FOUND: Controller file '" . $this->__controller . "' not exist. Make sure you have created your controller file.", 404);
        }

        require_once "app/controllers/" . $url_check . ".php";

        if (!class_exists($this->__controller)) {
            // Kiểm tra lớp controller có tồn tại không
            throw new RuntimeException("CLASS NOT FOUND: Controller class '" . $this->__controller . "' not exist. Make sure you name your controller class match with controller file name!", 404);
        } else if (!method_exists($this->__controller, $this->__action)) {
            // Kiểm tra xem method của controller có tồn tại hay không
            throw new RuntimeException("METHOD NOT FOUND: Method '" . $this->__controller . "->" . $this->__action . "()' not exist. Maybe you missing your action method in your controller class", 404);
        } else {
            $this->__controller = new $this->__controller();
            if (!empty($this->__db)) {
                $this->__controller->db = $this->__db;
            }

            // Hàm thực thi 
            call_user_func_array([$this->__controller, $this->__action], $this->__parameters);
        }
    }

    /**
     * Xuất lỗi thành một trang web dựa theo mã lỗi và dữ liệu truyền vào
     * @param string $name Mã lỗi. Mặc định lỗi được truyền có mã `500`.
     * @param array $data Dữ liệu truyền vào. Mặc định mảng là rỗng.
     */
    public function load_error($name = "500", $data = [])
    {
        require_once "app/errors/" . $name . ".php";
    }
}
