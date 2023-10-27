<?php

namespace app\core\controller;

class Hometest extends BaseController
{
    private $__data = [];
    public function index()
    {
        $this->__data['view'] = "test/web_test/page/home";
        $this->render_view("layouts/layout_webtest", $this->__data);
    }
}
