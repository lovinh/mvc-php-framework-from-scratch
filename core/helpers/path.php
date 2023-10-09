<?php

/**
 * Trả về url trang web của dự án. Đường dẫn sử dụng '/'
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về url kết nối giữa trang web kèm theo phần đường dẫn tương đối.
 * @return string url của trang web kèm theo đường dẫn bổ sung (nếu có)
 */
function web_path($relative_path = '')
{
    return _WEB_ROOT . (!empty($relative_path) ? ('/' . $relative_path) : false);
}
/**
 * Trả về url tới thư mục public trang web của dự án. Đường dẫn sử dụng '/'
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về url kết nối giữa trang web kèm theo phần đường dẫn tương đối.
 * @return string Trả về url tới thư mục public trang web của dự án kèm theo đường dẫn bổ sung (nếu có).
 */
function public_url_path($relative_path = '')
{
    return _WEB_ROOT . '/public' . (!empty($relative_path) ? ('/' . $relative_path) : false);
}
/**
 * Trả về đường dẫn tuyệt đối của ứng dụng. Đường dẫn sử dụng '\'.
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về đường dẫn kèm theo phần đường dẫn tương đối.
 * @return string Đường dẫn gốc của ứng dụng kèm theo đường dẫn bổ sung (nếu có)
 */
function app_path($relative_path = '')
{
    return _DIR_ROOT . '\\app' . (!empty($relative_path) ? ('\\' . $relative_path) : false);
}
/**
 * Trả về đường dẫn tuyệt đối đến thư mục config của dự án. Đường dẫn sử dụng '\'.
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về đường dẫn kèm theo phần đường dẫn tương đối.
 * @return string Đường dẫn gốc tới phần config kèm theo đường dẫn bổ sung (nếu có)
 */
function config_path($relative_path = '')
{
    return _DIR_ROOT . '\\config' . (!empty($relative_path) ? ('\\' . $relative_path) : false);
}
/**
 * Trả về đường dẫn tuyệt đối đến thư mục public của dự án. Đường dẫn sử dụng '\'.
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về đường dẫn kèm theo phần đường dẫn tương đối.
 * @return string Đường dẫn gốc tới phần public kèm theo đường dẫn bổ sung (nếu có)
 */
function public_path($relative_path = '')
{
    return _DIR_ROOT . '\\public' . (!empty($relative_path) ? ('\\' . $relative_path) : false);
}
