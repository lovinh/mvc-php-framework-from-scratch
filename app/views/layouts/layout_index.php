<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/css/style.css">
    <title><?php echo (!empty($data['page_title']) ? $data['page_title'] : "Trang chủ"); ?></title>
</head>

<body>
    <?php
    load_view("blocks/header");
    ?>
    <hr />
    <main>
        <div>
            <?php
            load_view($data['content'], $data['sub_content']);
            ?>
        </div>
    </main>
    <hr />
    <?php
    load_view("blocks/footer");
    ?>
    <script type="text/javascripts" src="<?php echo _WEB_ROOT; ?>/public/assets/js/script.js"></script>

</body>

</html>