@php
use function app\core\helper\load_view;
use function app\core\helper\render_block;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/css/style.css">
    <title>{{$data["title"]}}</title>
</head>

<body>
    @php
    render_block("blocks/header");
    @endphp
    <hr />
    <main>
        <div>Author: {{$data["author"]}}</div>
        <div>
            @php
            render_block($data["content"], $data);
            @endphp
        </div>
    </main>
    <hr />
    @php
    render_block("blocks/footer");
    @endphp
    <script type="text/javascripts" src="<?php echo _WEB_ROOT; ?>/public/assets/js/script.js"></script>

</body>

</html>