<?php

namespace app\core\helper;

if (!function_exists("to_slug")) {
    function to_slug($value)
    {
        return $value;
    }
}
/**
 * Chuyển hướng đến đường dẫn đích
 * @param string $url_location Đường dẫn địa chỉ chuyển hướng tới
 * @param int $code mã trạng thái phản hồi. Mặc định là 301
 */
function redirect(string $url_location, int $code = 301)
{
    http_response_code($code);
    header('Location: ' . $url_location);
}
