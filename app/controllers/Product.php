<?php
class Product extends BaseController
{
    public $data = [];
    function index()
    {
        $model = $this->get_model("ItemList");
        $this->data['list_items'] = $model->get_list_items();
        $this->render_view("product/index", $this->data);
    }
    function detail($id = 0)
    {
        $model = $this->get_model("ItemList");
        $item = $model->get_item_by_id($id);
        $this->render_view("product/detail", $item);
    }
}
