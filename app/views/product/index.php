<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Trang sản phẩm</h1>
    <?php
    foreach ($data['list_items'] as $value) {
        echo "<div><h2>id = " . $value->get_id() . "</h2><h2>Name: " . $value->get_name() . "</h2><h2>Price: " . $value->get_price() . "$</h2></div></br>";
    }
    ?>
</body>

</html>