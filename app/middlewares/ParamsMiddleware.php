<?php

namespace app\core\middleware;

use app\core\http_context\Request;
use app\core\Route;
use function app\core\helper\path_info;

class ParamsMiddleware implements IMiddleware
{
    public function handle(Request $request, callable $next)
    {
        // if (path_info() == "/home/search")
        //     return;
        // if (!empty($this->request->query_string)) {
        //     $this->response->redirect(Route::get_full_url());
        // }
        // echo "Handle Params Middleware. Url: " . $request->full_url() . " </br>";

        return $next($request);
    }
}
