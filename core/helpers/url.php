<?php
if (!function_exists("array_is_list")) {
    function array_is_list(array $array): bool
    {
        $i = -1;
        foreach ($array as $k => $v) {
            ++$i;
            if ($k !== $i) {
                return false;
            }
        }
        return true;
    }
}
/**
 * Trả về url trang web của dự án. Đường dẫn sử dụng '/'
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về url kết nối giữa trang web kèm theo phần đường dẫn tương đối.
 * @return string url của trang web kèm theo đường dẫn bổ sung (nếu có)
 */
function url($relative_path = '')
{
    return _WEB_ROOT . (!empty($relative_path) ? ('/' . $relative_path) : false);
}
/**
 * Trả về url tới thư mục public trang web của dự án. Đường dẫn sử dụng '/'
 * @param string $relative_path đường dẫn tương đối đến một file. Khi đó hàm trả về url kết nối giữa trang web kèm theo phần đường dẫn tương đối.
 * @return string Trả về url tới thư mục public trang web của dự án kèm theo đường dẫn bổ sung (nếu có).
 */
function public_url($relative_path = '')
{
    return _WEB_ROOT . '/public' . (!empty($relative_path) ? ('/' . $relative_path) : false);
}

/**
 * Sinh ra url ứng với action tương ứng của controller được cung cấp
 * @param array $controller_action mảng chỉ chứa 2 phần tử gồm controller và action, hai phần tử phải là chuỗi. Nếu chỉ cho 1 phần tử thì mặc định sẽ là tên controller và action mặc định
 */
function action(array $controller_action, array $params = []): string
{
    if (empty($controller_action)) {
        throw new ValueError("HELPER ACTION EMPTY ARGUMENT: Tên controller và tên action không được để trống");
    }
    if (!is_array($controller_action)) {
        throw new ValueError("HELPER ACTION NOT ARRAY: Tham số controller_action phải là một mảng!");
    }
    if (count($controller_action) > 2) {
        throw new OutOfBoundsException("HELPER ACTION OUT OF PARAMS: Truyền vào quá nhiều tham số đối với controller_action. Chỉ truyền dưới 2 tham số");
    }
    if (count($controller_action) == 1) {
        array_push($controller_action, "index");
    }
    if (!(is_string($controller_action[0]) && is_string($controller_action[1]))) {
        throw new InvalidArgumentException("HELPER ACTION INVALID ARGUMENT: Tham số truyền vào controller_action không hợp lệ. Yêu cầu một chuỗi");
    }
    $url = _WEB_ROOT . '/' . strtolower($controller_action[0]) . '/' . strtolower($controller_action[1]);
    if (array_is_list($params)) {
        foreach ($params as $element) {
            $url .= '/' . $element;
        }
    } else {
        $url .= '?';
        foreach ($params as $key => $value) {
            $url .= "$key=$value" . '&';
        }
        $url = rtrim($url, '&');
    }
    return $url;
}
/**
 * Sinh ra một url đến thư mục assets của dự án hoặc tới file nằm trong assets của dự án
 * @param string $file_path Đường dẫn tương đối đến file chỉ định. Mặc định là rỗng.
 * @return string url trỏ tới thư mục assets hoặc file thuộc assets nằm trong dự án.
 */
function assets($file_path = '')
{
    $url = _WEB_ROOT . '/public/assets';
    if (!empty($file_path)) {
        $url .= '/' . $file_path;
    }
    return $url;
}
