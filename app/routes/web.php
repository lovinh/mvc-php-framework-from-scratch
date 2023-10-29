<?php

namespace app\core;

use app\core\controller\Home;
use app\core\controller\Product;
use app\core\view\View;

Route::get("/san-pham", [Product::class, 'index'])->name("product");

Route::get("/", [Home::class, 'index']);

Route::get("/test", function () {
    View::render("test");
});

Route::delete("/delete", function () {
    echo "DELETED!";
});

Route::any("/any", function () {
    echo "ANY REQUEST METHOD ALLOW!";
});

Route::match(["get", "post"], "/match", function () {
    echo "MATCH REQUEST METHOD ALLOW!";
});

Route::redirect('/hey', '/');

Route::get("/mat-hang/{ma-mat-hang}", function ($id) {
    return "Mã mặt hàng: {$id}";
});
Route::get("/san-pham/ma-mat-hang/{id}", [Product::class, 'detail']);

Route::get("/test-params/{id}/{name}/{size}", function ($id, $name, $size) {
    echo "Id: $id" . "</br>";
    echo "Name: $name" . "</br>";
    echo "Size: $size" . "</br>";
});