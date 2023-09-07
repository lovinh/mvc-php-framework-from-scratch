<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Chi tiết sản phẩm</h1>
    <?php
    if (!empty($data)) {
        echo "<h2>Mã sản phẩm: " . $data->get_id() . "</h2>";
        echo "<h2>Tên sản phẩm: " . $data->get_name() . "</h2>";
        echo "<h2>Giá: " . $data->get_price() . "$</h2>";
    } else {
        echo "<h2>Không tìm thấy sản phẩm</h2>";
    }
    ?>
</body>

</html>