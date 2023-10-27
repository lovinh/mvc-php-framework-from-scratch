<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data["page_title"]; ?></title>

    <link rel="stylesheet" href="<?php echo _WEB_ROOT . '/public' ?>/assets/bootstrap-5.0.2-dist/css/bootstrap.css">
    <script src="<?php echo _WEB_ROOT . '/public' ?>/assets/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="<?php echo _WEB_ROOT . '/public' ?>/assets/css/login.css">
    <link rel="shortcut icon" href="<?php echo _WEB_ROOT . '/public' ?>/assets/icon.png" type="image/x-icon">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form action="register" method="post">
            <img class="mb-4" src="<?php echo _WEB_ROOT . '/public' ?>/assets/icon.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 fw-normal">Please sign up</h1>
            <?php
            if (!empty($data["errors"])) {
                $error_msg = reset($data["errors"]);
                echo '<div class="alert alert-danger" role="alert">' . $error_msg . '</div>';
            }
            ?>

            <div class="form-floating m-1">
                <input type="text" class="form-control" id="first-name" name="first-name" placeholder="Your first name" value="<?php echo !empty($data["field_data"]["first-name"]) ? $data["field_data"]["first-name"] : false; ?>">
                <label for="first-name">Your first name</label>
            </div>
            <div class="form-floating m-1">
                <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Your first name" value="<?php echo !empty($data["field_data"]["last-name"]) ? $data["field_data"]["last-name"] : false; ?>">
                <label for="last-name">Your last name</label>
            </div>
            <div class="form-floating m-1">
                <input type="text" class="form-control" id="email" name="email" placeholder="Your email" value="<?php echo !empty($data["field_data"]["email"]) ? $data["field_data"]["email"] : false; ?>">
                <label for="email">Your email</label>
            </div>
            <div class="form-floating m-1">
                <input type="password" class="form-control" id="password" name="password" placeholder="Your password">
                <label for="password">Your password</label>
            </div>
            <div class="form-floating m-1">
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
                <label for="confirm-password">Confirm your password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember-me" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
            <div class="mt-5 mb-3">Have an account?
                <a href="dang-nhap">Sign in</a>
            </div>
        </form>
    </main>

</body>

</html>