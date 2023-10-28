<?php

namespace app\core;

Route::get("/san-pham", "product")->name("product");

Route::get("/san-pham/detail/{id}", "product/detail/$1");
Route::get("/san-pham/detail/{id}", "product/detail/$1");
Route::get("/san-pham/detail/{id}", "product/detail/$1")->name("test");
Route::get("/san-pham/detail/{id}", "product/detail/$1");