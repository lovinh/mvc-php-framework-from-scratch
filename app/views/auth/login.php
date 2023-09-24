<?php
echo (!empty($data["msg"]) ? $data["msg"] : false);
?>
<div style="display: flex; justify-content: center; height: 100vh;">
    <div style="display: flex; justify-content: center; align-items: center;">
        <form action="<?php echo _WEB_ROOT ?>/auth/logined" method="POST" style="display: flex; flex-direction: column; width: 500px; ">
            <label for="name">Username:</label>
            <div style="margin-bottom: 10px;">
                <input type="text" id="name" name="name" value="<?php echo !empty($data["field_data"]["name"]) ? $data["field_data"]["name"] : false; ?>" style=" width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["name"]) ? $data["errors"]["name"] : false; ?></span>
            </div>

            <label for="password">Mật khẩu:</label>
            <div style="margin-bottom: 10px;">
                <input type="password" id="password" name="password" style="width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["password"]) ? $data["errors"]["password"] : false; ?></span>
            </div>

            <div style="display: flex; flex-direction: column; align-items: center;">
                <input type="submit" value="Đăng nhập" style="width: 120px;">
            </div>

        </form>
    </div>
</div>