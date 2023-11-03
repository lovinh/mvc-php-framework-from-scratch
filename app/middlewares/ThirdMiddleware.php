<?php

use app\core\http_context\Request;
use app\core\middleware\IMiddleware;

class ThirdMiddleware implements IMiddleware
{
    public function handle(Request $request, callable $next)
    {
        echo "ThirdMiddleware: Handled! </br>";
        return $next($request);
    }
}
