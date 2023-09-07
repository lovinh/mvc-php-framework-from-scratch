<?php
class Home
{
    function index()
    {
        echo "Trang chủ";
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
}
