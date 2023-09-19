<?php
class Response
{
    /**
     * Chuyển hướng phản hồi đến đường dẫn mới
     * @param string $uri định dạng tài nguyên hệ thống. Mặc định là chuỗi rỗng. Nếu không chỉ định, tự động chuyển hướng đến trang gốc.
     */
    public function redirect($uri = "")
    {
        // Kiểm tra xem có http|https không
        if (preg_match("~^(http|https)~is", $uri)) {
            $url = $uri;
        } else {
            $url = _WEB_ROOT . '/' . $uri;
        }
        header("Location: " . $url);
    }
}
