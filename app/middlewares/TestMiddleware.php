<?php

use app\core\http_context\Request;
use app\core\middleware\IMiddleware;

class TestMiddleware implements IMiddleware
{
    public function handle(Request $request, callable $next)
    {
        echo "TestMiddleware: Kiểm tra thử TestMiddleware </br>";

        return $next($request);
    }
}
