<?php

namespace app\core\view;

use app\core\http_context\Response;
use app\core\Template;

use function app\core\helper\response;
use function app\core\helper\view_path;

class View
{
    public static $data_share = [];
    public static function share($data)
    {
        self::$data_share = $data;
    }

    public static function render($view_name, $data = [])
    {
        $content_view = file_get_contents(view_path("$view_name.php"));
        $template = new Template();
        ob_start();
        $template->run($content_view, $data);
        $content = ob_get_contents();
        ob_end_clean();
        return response()->set_content($content);
    }
}
