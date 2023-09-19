<?php
class User extends BaseController
{
    public function index()
    {
        echo "<h1>Trang người dùng</h1>";
    }
    public function add_user()
    {
        $request = new Request();
        $this->render_view('users/add_user');
    }
}
