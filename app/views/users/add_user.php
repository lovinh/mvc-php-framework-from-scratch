<?php

?>
<div style="display: flex; justify-content: center; height: 100vh;">
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div><?php echo (!empty($data["msg"]) ? $data["msg"] : false) ?></div>
        <form action="<?php echo _WEB_ROOT ?>/user/post_user" method="POST" style="display: flex; flex-direction: column; width: 500px; ">
            <label for="name">Họ tên:</label>
            <div style="margin-bottom: 10px;">
                <input type="text" id="name" name="name" value="<?php echo !empty($data["field_data"]["name"]) ? $data["field_data"]["name"] : false; ?>" style=" width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["name"]) ? $data["errors"]["name"] : false; ?></span>
            </div>

            <label for="email">Email:</label>
            <div style="margin-bottom: 10px;">
                <input type="email" id="email" name="email" value="<?php echo !empty($data["field_data"]["email"]) ? $data["field_data"]["email"] : false; ?>" style="width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["email"]) ? $data["errors"]["email"] : false; ?></span>
            </div>

            <label for="age">Age:</label>
            <div style="margin-bottom: 10px;">
                <input type="text" id="age" name="age" value="<?php echo !empty($data["field_data"]["age"]) ? $data["field_data"]["age"] : false; ?>" style="width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["age"]) ? $data["errors"]["age"] : false; ?></span>
            </div>

            <label for="password">Mật khẩu:</label>
            <div style="margin-bottom: 10px;">
                <input type="password" id="password" name="password" style="width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["password"]) ? $data["errors"]["password"] : false; ?></span>
            </div>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <div style="margin-bottom: 20px;">
                <input type="password" id="confirm_password" name="confirm_password" style="width:100%;">
                <span style="color: red;"><?php echo !empty($data["errors"]["confirm_password"]) ? $data["errors"]["confirm_password"] : false; ?></span>
            </div>

            <div style="display: flex; flex-direction: column; align-items: center;">
                <input type="submit" value="Đăng ký" style="width: 120px;">
            </div>

        </form>
    </div>
</div>