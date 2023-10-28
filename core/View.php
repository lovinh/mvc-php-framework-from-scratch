<?php

namespace app\core\view;

use app\core\Template;
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
        $template->run($content_view, $data);
    }
}
