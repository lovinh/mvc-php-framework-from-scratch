<?php

namespace app\core;

use app\core\controller\FileUpload as ControllerFileUpload;
use app\core\controller\Home;
use app\core\controller\Hometest;
use app\core\controller\Product;
use app\core\controller\test\Auth;
use app\core\controller\test\webtest\Product as WebtestProduct;
use app\core\http_context\Request;
use app\core\middleware\AuthMiddleware;
use app\core\view\View;
use FileUpload;
use SecondMiddleware;
use TestMiddleware;
use ThirdMiddleware;

use function app\core\helper\route_url;

// Route::get("/san-pham", [Product::class, 'index'])->name("product");
// Route::get("/san-pham/ma-mat-hang/{id}", [Product::class, 'detail']);

Route::group(function () {
    Route::get("/san-pham", "index");
    Route::get("/san-pham/ma-mat-hang/{id}", "detail");
})->controller(Product::class);

Route::get("/", [Home::class, 'index']);

Route::get("/test", function () {
    echo (new Request())->url();
    return View::render("test");
});

Route::delete("/delete", function () {
    return "DELETED!";
});

Route::any("/any", function () {
    return "ANY REQUEST METHOD ALLOW!";
});

Route::match(["get", "post"], "/match", function () {
    return "MATCH REQUEST METHOD ALLOW!";
});

Route::group(function () {
    Route::get("/group/test1", function () {
        return "Group test 1 </br>";
    });
    Route::get("/group/test2", function () {
        return "Group test 2 </br>";
    });
})->middleware([SecondMiddleware::class, ThirdMiddleware::class]);

Route::redirect('/hey', '/');

Route::get("/mat-hang/{ma-mat-hang}", function ($id) {
    return "Mã mặt hàng: {$id}";
});

Route::get("/test-params/{id}/{name}/{size}", function ($id, $name, $size) {
    $content = "";
    $content .= "Id: $id" . "</br>";
    $content .= "Name: $name" . "</br>";
    $content .= "Size: $size" . "</br>";
    $content .= route_url('test-params', ["id" => 1, "name" => "tung", "size" => "s", "page" => 2]);
    $request = new Request();
    $data = $request->get_fields_data();
    $content .= "Page: " . $data['page'];
    return $content;
})->where("name", "[t]")->where_in("size", ['s', 'm', 'l'])->name('test-params');

Route::get("/test-middleware", function () {
    return "Kiểm tra middleware thui mà <3";
})->middleware([AuthMiddleware::class, TestMiddleware::class]);

Route::get('/webtest', [Hometest::class, 'index'])->name('webtest.home');
Route::get('/webtest/trang-chu', [Hometest::class, 'index']);
Route::get('/webtest/san-pham', [WebtestProduct::class, 'index'])->name('webtest.product');


Route::get("/json-test/{id}/{name}", function (string $id, string $name) {
    return [
        "id" => $id,
        "name" => $name
    ];
});

Route::group(function () {
    Route::match(['get', 'post'], "/file-upload", "index")->name("file.index");
    Route::post("/file-upload/uploading", "upload")->name('file.upload');
})->controller(ControllerFileUpload::class);

Route::match(['get', 'post'], "/dang-nhap", [Auth::class, "sign_in"]);
Route::post("/dang-nhap/dang-dang-nhap", [Auth::class, "login"]);
Route::match(['get', 'post'], "/xac-nhan-dang-nhap", [Auth::class, "index"]);
Route::post("/dang-xuat", [Auth::class, "logout"]);

Route::fallback(function () {
    http_response_code(404);
    return View::render("404");
});
