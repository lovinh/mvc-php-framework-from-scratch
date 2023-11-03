<?php

namespace app\core\controller;

use app\core\view\View;

class Hometest extends BaseController
{
    private $__data = [];
    public function index()
    {
        $this->__data['view'] = "test/web_test/page/home";
        // $this->render_view("layouts/layout_webtest", $this->__data);
        $this->__data['page'] = 'webtest.home';
        return View::render("layouts/layout_webtest", $this->__data);
    }
}
