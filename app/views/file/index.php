@php
use function app\core\helper\route_url;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Test</title>
</head>

<body>
    <div>
        <form action="{{route_url('file.upload')}}" enctype="multipart/form-data" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            </br style="margin-top:10px;">
            <label for="address">Địa chỉ</label>
            <input type="text" name="address" id="address">
            </br>
            <label for="age">Tuổi</label>
            <input type="number" name="age" id="age">
            </br>
            <input type="file" name="image" id="image">
            <input type="file" name="file" id="file">
            <button type="submit">Upload</button>
        </form>
    </div>
</body>

</html>