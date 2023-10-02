<?php
class User extends BaseController
{
    public $data = [];
    public function index()
    {
        echo "<h1>Trang người dùng</h1>";
    }
    public function get_user()
    {
        $this->data['sub_content']["errors"] = Session::flash("errors");
        $this->data['sub_content']["msg"] = Session::flash("msg");
        $this->data['sub_content']["field_data"] = Session::flash("field_data");
        $this->data['page_title'] = "Thêm người dùng";
        $this->data['content'] = "users/add_user";
        return $this->render_view('layouts/layout_index', $this->data);
    }
    public function post_user()
    {
        $data = [];

        $data["field_data"] = $this->request->get_fields_data();

        if ($this->request->is_post()) {

            // Set rule
            $min_age = 18;

            $this->request->validate->set_fields_data($data["field_data"]);
            $this->request->validate->set_message([
                "name.required" => "Họ tên không được để trống",
                "name.min_char" => "Họ tên cần có tối thiểu 5 ký tự",
                "name.max_char" => "Họ tên chỉ được có tối đa 30 ký tự",
                "email.required" => "Email không được để trống",
                "email.email" => "Không đúng định dạng email",
                "email.min_char" => "Email cần có tối thiểu 6 ký tự",
                "age.required" => "Tuổi không được để trống",
                "age.integer" => "Tuổi phải là một số nguyên",
                "age.min" => "Tuôi phải lớn hơn $min_age",
                "password.required" => "Mật khẩu không được để trống",
                "password.min_char" => "Mật khẩu cần có tối thiểu 8 ký tự",
                "confirm_password.required" => "Xác nhận mật khẩu không được để trống",
                "confirm_password.min_char" => "Xác nhận mật khẩu cần có tối thiểu 8 ký tự",
                "confirm_password.match" => "Xác nhận mật khẩu phải trùng với mật khẩu"
            ]);
            $this->request->validate->field("name")->required()->min_char(5)->max_char(30);
            $this->request->validate->field("email")->required()->email()->min_char(6);
            $this->request->validate->field("age")->required()->integer()->between(18, 35, "Tuổi phải nằm trong khoảng từ 18 đến 35");
            $this->request->validate->field("password")->required()->min_char(8);
            $this->request->validate->field("confirm_password")->required()->min_char(8)->match("password");

            if ($this->request->validate->is_error()) {
                Session::flash("errors", $this->request->validate->get_first_error());
                Session::flash("msg", "Đã có lỗi xảy ra!");
                Session::flash("field_data", $this->request->get_fields_data());
            } else {
                return $this->response->redirect("user/index");
            }
        }

        return $this->response->redirect("user/get_user");
    }

    public function check_age($age)
    {
        return $age >= 18;
    }
}
