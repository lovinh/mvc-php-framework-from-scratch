<?php
if (!empty($_SERVER["argv"][1])) {
    switch ($_SERVER["argv"][1]) {
        case 'create:controller':
            if (!empty($_SERVER["argv"][2])) {

                $controller_name = $_SERVER["argv"][2];

                if (filter_)

                if (!file_exists("app/controllers/$controller_name.php")) {
                    echo "Đã tạo controller $controller_name thành công!";
                } else {
                    echo "Controller có tên $controller_name đã tồn tại! Vui lòng lựa chọn một tên khác";
                }
            }

            break;

        default:
            # code...
            break;
    }
}
