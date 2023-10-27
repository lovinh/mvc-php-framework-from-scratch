<?php

namespace app\core\controller;

class Auth extends BaseController
{
    public function index()
    {
        echo "Đăng nhập thành công";
    }
    public function login()
    {
        $this->render_view("auth/login");
    }
    public function logined()
    {
        $data = [];
        $data["field_data"] = $this->request->get_fields_data();
        if ($this->request->is_post()) {

            // Set rule
            $this->request->validate->set_fields_data($data["field_data"]);
            $this->request->validate->set_message([
                "name.required" => "Username không được để trống",
                "name.min_char" => "Username cần có tối thiểu 6 ký tự",
                "password.required" => "Mật khẩu không được để trống",
                "password.min_char" => "Mật khẩu cần có tối thiểu 1 ký tự",
            ]);
            $this->request->validate->field("name")->required()->min_char(6);
            $this->request->validate->field("password")->required()->min_char(1);

            if ($this->request->validate->is_error()) {
                $data["errors"] = $this->request->validate->get_first_error();
                $data["msg"] = "Đã có lỗi xảy ra!";
            } else {
                $user = $this->db->table("users")->where("username", "=", $data["field_data"]["name"])->where("password", "=", $data["field_data"]["password"])->first();
                if (empty($user)) {
                    echo "Tài khoản hoặc mật khẩu không đúng!";
                } else {
                    echo "Đăng nhập thành công";
                    $this->response->redirect("auth/index");
                }
            }
            $this->render_view("auth/login", $data);
        } else {
            $this->response->redirect("auth/login");
        }
    }
}
