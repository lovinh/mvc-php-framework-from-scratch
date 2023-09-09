<h1>Chi tiết sản phẩm</h1>
<?php
if (!empty($this->data['sub_content']['item'])) {
    echo "<h2>Mã sản phẩm: " . $this->data['sub_content']['item']->get_id() . "</h2>";
    echo "<h2>Tên sản phẩm: " . $this->data['sub_content']['item']->get_name() . "</h2>";
    echo "<h2>Giá: " . $this->data['sub_content']['item']->get_price() . "$</h2>";
} else {
    echo "<h2>Không tìm thấy sản phẩm</h2>";
}
?>