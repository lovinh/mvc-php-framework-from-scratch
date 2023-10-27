<?php

namespace app\core\controller;

use app\core\http_context\Request;
use app\core\http_context\Response;
use app\core\Template;

use function app\core\helper\load_model;
use function app\core\helper\load_view;
use function app\core\helper\view_path;

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
        return load_model($model_name);
    }
    /**
     * Xuất view tương ứng với tên và dữ liệu được truyền vào
     * @param string $view_name Tên view cần xuất
     * @param array $data Dữ liệu truyền vào view
     * @return null
     */
    public function render_view($view_name, $data = [])
    {
        // ob_start();
        // load_view($view_name, $data);
        // $content_view = ob_get_contents();
        // ob_end_clean();

        $content_view = file_get_contents(view_path("$view_name.php"));
        $template = new Template();
        $template->run($content_view, $data);
    }
}
