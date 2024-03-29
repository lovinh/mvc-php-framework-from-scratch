<?php

namespace app\core\controller;

class Product extends BaseController
{
    public $data = [];
    function index()
    {
        $model = $this->get_model("ItemList");
        $this->data['sub_content']['list_items'] = $model->get_list_items();
        $this->data['title'] = "Danh sách sản phẩm";
        $this->data['content'] = "product/index";
        $this->data['title'] = "Sản phẩm";
        $this->data["author"] = "a3lita";
        return $this->render_view("layouts/layout_index", $this->data);
        // $model = $this->get_model("ItemList");
    }
    function detail($id = 0)
    {
        $model = $this->get_model("ItemList");
        $this->data['sub_content']['item'] = $model->get_item_by_id($id);
        $this->data['title'] = "Chi tiết sản phẩm";
        $this->data['content'] = "product/detail";
        return $this->render_view("layouts/layout_index", $this->data);
    }
}
