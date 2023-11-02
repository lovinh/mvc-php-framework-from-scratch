<?php

namespace app\core\middleware;

use app\core\http_context\Request;

class AuthMiddleware implements IMiddleware
{
    public function handle(Request $request, callable $next)
    {
        echo "AuthMiddleware: Người dùng phải đăng nhập Path: " . $request->path() . "</br>";
        $response = $next($request);

        if ($request->like_path("/san-pham/*")) {
            $response->redirect("home");
        } else {
            echo "Không liên quan đến sản phẩm </br>";
        }
        return $response;
    }
}
