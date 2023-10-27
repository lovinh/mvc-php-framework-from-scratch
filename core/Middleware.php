<?php

namespace app\core\middleware;

use app\core\http_context\Request;
use app\core\http_context\Response;

abstract class BaseMiddleware
{
    protected $request;
    protected $response;
    protected $db;

    function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function set_db($db)
    {
        $this->db = $db;
    }

    abstract public function handle();
}
