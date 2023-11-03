<?php

namespace app\core\controller;

class News extends BaseController
{
    public function index()
    {
        $data = [];
        $data["title"] = "Tin tức";
        $data["new_author"] = "a3lita";
        $data["new_title"] = "Tin tức 1";
        $data["new_content"] = "Nội dung 1";
        $data["new_subcontent"] = "Nội dung nhỏ 1";
        $data["new_author"] = "a3lita";
        $data["content"] = "news/list";
        return $this->render_view("layouts/layout_index", data: $data);
    }
}
