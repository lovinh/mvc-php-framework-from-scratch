<?php

namespace app\core\controller;

use app\core\Route;
use app\core\view\View;

class Home extends BaseController
{
    public function index()
    {
        // $this->render_view("home\index");
        echo '<pre>';
        print_r(Route::$routes);
        echo '</pre>';
        return View::render("home\index");
    }
    public function search($id = "", $name = "")
    {
        echo "Run search method" . "</br>";

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
