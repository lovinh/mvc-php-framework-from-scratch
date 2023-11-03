@php
use function app\core\helper\public_url;
use function app\core\helper\assets;
use function app\core\helper\render_block;

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet" />

  <title>Pixie - Ecommerce HTML5 Template</title>

  <!-- Bootstrap core CSS -->
  <link href="{{public_url('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="{{assets('css/fontawesome.css')}}" />
  <link rel="stylesheet" href="{{assets('css/tooplate-main.css')}}" />
  <link rel="stylesheet" href="{{assets('css/owl.css')}}" />
  <!--
Tooplate 2114 Pixie
https://www.tooplate.com/view/2114-pixie
-->
</head>

<body>
  @php
  render_block("test/web_test/block/header", $data);
  @endphp

  <!-- Page Content -->
  @php
  render_block($data['view'], $data);
  @endphp

  @php
  render_block("test/web_test/block/footer", $data);
  @endphp

  <!-- Bootstrap core JavaScript -->
  <script src="{{public_url('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{public_url('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Additional Scripts -->
  <script src="{{assets('js/custom.js')}}"></script>
  <script src="{{assets('js/owl.js')}}"></script>

  <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t) {
      //declaring the array outside of the
      if (!cleared[t.id]) {
        // function makes it static and global
        cleared[t.id] = 1; // you could use true and false, but that's more typing
        t.value = ""; // with more chance of typos
        t.style.color = "#fff";
      }
    }
  </script>
</body>

</html>