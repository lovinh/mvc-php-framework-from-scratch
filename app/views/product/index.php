<h1>Trang sản phẩm</h1>
<?php
foreach ($data['list_items'] as $value) {
    echo "<div><h2>id = " . $value->get_id() . "</h2><h2>Name: " . $value->get_name() . "</h2><h2>Price: " . $value->get_price() . "$</h2></div></br>";
}
?>