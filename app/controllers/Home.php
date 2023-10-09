<?php
class Home extends BaseController
{
    public function index()
    {
        echo CustomClass::foo();
        $this->render_view("home/index");
    }
    public function search($id = "", $name = "")
    {
        if (!empty($_GET["page"])) {
            $page = $_GET["page"];
        } else $page = 1;
        if (empty($id)) {
            $id = $_GET["id"];
        }
        if (empty($name)) {
            $name = $_GET["name"];
        }
        echo "id = " . $id . "<br/>";
        echo "name = " . $name . "<br/>";
        echo "page = " . $page . "<br/>";
    }
    public function test()
    {
        $data = $this->db->table("users")->where("id", ">", 3)->where("id", "<", 12)->order_by("username")->get();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    public function get_category()
    {
        $this->render_view('categories/add');
    }
    public function post_category()
    {
        $data = $this->request->get_fields_data();
        $this->response->redirect("https://facebook.com");
    }
}
