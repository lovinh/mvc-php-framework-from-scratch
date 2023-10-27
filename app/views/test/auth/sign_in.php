@php
use function app\core\helper\assets;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data["page_title"] }}</title>

    <link rel="stylesheet" href="{{assets('bootstrap-5.0.2-dist/css/bootstrap.css')}}">
    <script src="{{ assets('bootstrap-5.0.2-dist/js/bootstrap.js') }}"></script>
    <link rel="stylesheet" href="{{ assets('css/login.css') }}">
    <link rel="shortcut icon" href="{{ assets('icon.png') }}" type="image/x-icon">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form action="login" method="post">
            <img class="mb-4" src="{{ assets('icon.png') }}" alt="" width="72" height="72">
            <h1 class="h3 mb-3 fw-normal">Sign in</h1>

            @if (!empty($data["errors"]))
            @php
            $error_msg = reset($data["errors"]);
            @endphp
            <div class="alert alert-danger" role="alert">' {{$error_msg}} </div>
            @endif
            <div class="form-floating m-1">
                <input type="text" class="form-control" id="email" name="email" placeholder="Your email" value="{{ !empty($data['field_data']['email']) ? $data['field_data']['email'] : false }}">
                <label for="email">Your email</label>
            </div>
            <div class="form-floating m-1">
                <input type="password" class="form-control" id="password" name="password" placeholder="Your password">
                <label for="password">Your password</label>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember-me" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <div class="mt-5 mb-3">Have an account?
                <a href="dang-ky">Sign in</a>
            </div>
        </form>
    </main>

</body>

</html>