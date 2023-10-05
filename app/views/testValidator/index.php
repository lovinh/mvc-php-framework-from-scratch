<?php
echo "Error:";
echo '<pre>';
print_r($data["errors"]);
echo '</pre>';
echo "Data:";
echo '<pre>';
var_dump($data["data"]);
echo '</pre>';
?>
<div>
    <form action="<?php echo _WEB_ROOT . "/testvalidator" ?>" method="post">
        <label for="username">Nhập cái gì đó</label>
        <input type="text" name="username" id="username">
        <label for="test2">Nhập cái gì đó nữa đi</label>
        <input type="text" name="test2" id="test2">
        <button type="submit">Test</button>
    </form>
</div>