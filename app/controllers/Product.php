<?php
class Product extends BaseController
{
    public $data = [];
    function index()
    {
        $model = $this->get_model("ItemList");
        $this->data['sub_content']['list_items'] = $model->get_list_items();
        $this->data['page_title'] = "Danh sách sản phẩm";
        $this->data['content'] = "product/index";
        $this->render_view("layouts/layout_index", $this->data);
    }
    function detail($id = 0)
    {
        $model = $this->get_model("ItemList");
        $this->data['sub_content']['item'] = $model->get_item_by_id($id);
        $this->data['page_title'] = "Chi tiết sản phẩm";
        $this->data['content'] = "product/detail";
        $this->render_view("layouts/layout_index", $this->data);
    }
}
