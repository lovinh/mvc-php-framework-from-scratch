<?php

/**
 * Lớp nền của các lớp controller.
 * @property Database $db Đối tượng database, cho phép thực hiện các tác vụ liên quan đến truy vấn từ CSDL.
 * @property Request $request Đối tượng request, cho phép thực hiện các tác vụ liên quan đến xử lý request từ client.
 * @property Response $response Đối tượng response, cho phép thực hiện các tác vụ liên quan đến xử lý response từ server.
 */
class BaseController
{
    public $db;
    public $request;
    public $response;

    function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }
    /**
     * Trả về đối tượng model cụ thể
     * @param string $model_name Tên model cần lấy
     * @return object Trả về đối tượng model được khởi tạo có tên tương ứng.
     */
    public function get_model($model_name)
    {
        return model_loader($model_name);
    }
    /**
     * Xuất view tương ứng với tên và dữ liệu được truyền vào
     * @param string $view_name Tên view cần xuất
     * @param array $data Dữ liệu truyền vào view
     * @return null
     */
    public function render_view($view_name, $data = [])
    {
        global $app_config;
        if (!file_exists(_DIR_ROOT . "/app/views/" . $view_name . ".php")) {
            // Handle error if view file not exist
            if ($app_config["debug_mode"]) {
                trigger_error("File view '" . $view_name . ".php' not exist!", E_USER_WARNING);
            }
            throw new ErrorException("File view '" . $view_name . ".php' not exist!");
        }

        require_once _DIR_ROOT . "/app/views/" . $view_name . ".php";
    }
}
