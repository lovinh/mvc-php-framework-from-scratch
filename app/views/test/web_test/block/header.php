@php
use function app\core\helper\assets;
use function app\core\helper\route_url;

@endphp
<!-- Pre Header -->
<div id="pre-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span>Suspendisse laoreet magna vel diam lobortis imperdiet</span>
            </div>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="{{assets('images/header-logo.png')}}" alt="" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{$data['page'] == 'webtest.home' ? 'active': false}}">
                    <a class="nav-link" href="{{route_url('webtest.home')}}">Home
                    </a>
                </li>
                <li class="nav-item {{$data['page'] == 'webtest.product' ? 'active' : false}}">
                    <a class="nav-link" href="{{route_url('webtest.product')}}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>