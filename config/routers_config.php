<?php
$router["default_controller"] = "home";

// Config router
/**
 * [Actual URL] => [Virtual URL]
 */
$router["san-pham"] = "product/index";
$router["san-pham/(.+)"] = "product/detail/$1";
$router["trang-chu"] = "home/index";
$router["trang-chu/(.+)"] = "home/$1";
$router["san-pham/chi-tiet-san-pham/(.+)"] = "product/detail/$1";
$router["san-pham/chi-tiet-san-pham"] = "product/detail";

$router["kiem-tra/dang-ky"] = "test/auth/sign_up";
$router["kiem-tra/dang-nhap"] = "test/auth/sign_in";
$router["kiem-tra/register"] = "test/auth/register";
$router["kiem-tra/login"] = "test/auth/login";
