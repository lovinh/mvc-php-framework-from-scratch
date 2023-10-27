<?php

namespace app\core\controller;

class Product extends BaseController
{
    public function index()
    {
        $data = [
            "view" => "test/web_test/page/product/index"
        ];
        $this->render_view("layouts/layout_webtest", $data);
    }
}
