<?php

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

/**
 * Trả về thông tin về đường dẫn hiện tại của yêu cầu từ người dùng
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về đường dẫn kèm theo phần đường dẫn tương đối.
 * @return string Đường dẫn hiện tại của yêu cầu từ người dùng
 */
function path_info($relative_path = '')
{
    return $_SERVER["PATH_INFO"] . (!empty($relative_path) ? ('/' . $relative_path) : false);
}
