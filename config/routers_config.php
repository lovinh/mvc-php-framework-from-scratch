<?php
$router["default_controller"] = "home";

// Config router
/**
 * [Actual URL] => [Virtual URL]
 */
$router["san-pham"] = "product/index";
$router["san-pham/(.+)"] = "product/$1";
$router["trang-chu"] = "home/index";
$router["trang-chu/(.+)"] = "home/$1";
$router["san-pham/chi-tiet-san-pham/(.+)"] = "product/detail/$1";
$router["san-pham/chi-tiet-san-pham"] = "product/detail";
