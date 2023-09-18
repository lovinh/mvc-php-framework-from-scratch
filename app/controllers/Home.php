<?php
class Home extends BaseController
{
    function index()
    {
        $this->render_view("home/index");
    }
    function search($id = "", $name = "")
    {
        if (!empty($_GET["page"]))
            $page = $_GET["page"];
        else $page = 1;
        echo "id = " . $id . "<br/>";
        echo "name = " . $name . "<br/>";
        echo "page = " . $page . "<br/>";
    }
    function test()
    {
        $data = $this->db->table("users")->where("id", ">", 3)->where("id", "<", 12)->order_by("username")->get();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
