<?php

use app\core\http_context\Request;
use app\core\middleware\IMiddleware;

class SecondMiddleware implements IMiddleware
{
    public function handle(Request $request, callable $next)
    {
        echo "SecondMiddleware: Handled! </br>";
        return $next($request);
    }
}
