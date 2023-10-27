<?php

namespace app\core\http_context;

class Request
{
    // private $__rules = [];
    // private $__messages = [];
    public $validate;
    public $query_string;
    function __construct()
    {
        $this->validate = new Validator();
        $this->query_string = !empty($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : "";
    }
    /**
     * Trả về loại phương thức yêu cầu (Request type).
     * @return string Trả về loại phương thức yêu cầu (Request type) dưới dạng lowercase.
     */
    public function get_method()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * Kiểm tra phương thức có phải là `POST` hay không
     * @return bool Trả về `true` nếu phương thức hiện tại đang là POST. Ngược lại trả về `false`.
     */
    public function is_post()
    {
        if ($this->get_method() == 'post') {
            return true;
        }
        return false;
    }
    /**
     * Kiểm tra phương thức có phải là `GET` hay không
     * @return bool Trả về `true` nếu phương thức hiện tại đang là `GET`. Ngược lại trả về `false`.
     */
    public function is_get()
    {
        if ($this->get_method() == 'get') {
            return true;
        }
        return false;
    }
    /**
     * Lấy dữ liệu được request.
     */
    public function get_fields_data()
    {
        $data_return = [];
        if ($this->is_get()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $data_return[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $data_return[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if ($this->is_post()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $data_return[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $data_return[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $data_return;
    }
}
