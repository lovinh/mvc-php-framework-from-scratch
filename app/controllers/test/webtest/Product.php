<?php

namespace app\core\controller\test\webtest;

use app\core\controller\BaseController;

class Product extends BaseController
{
    public function index()
    {
        $data = [
            "view" => "test/web_test/page/product/index",
            "page" => "webtest.product"
        ];
        return $this->render_view("layouts/layout_webtest", $data);
    }
}
