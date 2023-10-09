<?php
class Auth extends BaseController
{
    private $data = [];
    public function index()
    {
        echo "Trang chủ";
    }
    public function sign_up()
    {
        $data["errors"] = Session::flash("errors");
        $data["msg"] = Session::flash("msg");
        $data["field_data"] = Session::flash("field_data");
        $data['page_title'] = "Đăng ký";
        return $this->render_view("test/auth/sign_up", $data);
    }
    public function sign_in()
    {
        $data = [
            'page_title' => "Đăng nhập",
            'errors' => Session::flash("errors"),
            'field_data' => Session::flash("field_data")
        ];
        return $this->render_view("test/auth/sign_in", $data);
    }
    public function register()
    {
        if ($this->request->is_post()) {
            $this->request->validate->set_fields_data($this->request->get_fields_data());

            $this->request->validate->field("first-name")
                ->required("First name required!")
                ->string("First name must be a valid string!");

            $this->request->validate->field("last-name")
                ->required("Last name required!")
                ->string("Last name must be a valid string!");

            $this->request->validate->field("email")
                ->required("Email required!")
                ->string("Email must be a valid string!")
                ->email("Email must have type of email!")
                ->min_char(6, "Email must be 6 charactor minimum!")
                ->max_char(255, "Email must be 255 charactor maximum!")
                ->unique("users", '', "This email has been used!");

            $this->request->validate->field("password")
                ->required("Password required!")
                ->string("Password must be a valid string!")
                ->min_char(6, "Password must be 6 charactor minimum!")
                ->max_char(20, "Password must be 20 charactor maximum!")
                ->hashed();

            $this->request->validate->field("confirm-password")
                ->required("Confirmed password required!")
                ->string("Confirmed password must be a valid string!")
                ->min_char(6, "Confirmed password must be 6 charactor minimum!")
                ->max_char(20, "Confirmed password must be 20 charactor maximum!")
                ->hashed()
                ->match("password", "Confirmed password must match password!");

            if ($this->request->validate->is_error()) {
                Session::flash("errors", $this->request->validate->get_first_error());
                Session::flash("msg", "Đã có lỗi xảy ra!");
                Session::flash("field_data", $this->request->get_fields_data());
                $this->response->redirect("kiem-tra/dang-ky");
            } else {
                $validated_data = $this->request->validate->get_fields_data();
                $this->db->table("users")->insert_value([
                    "first_name" => $validated_data["first-name"],
                    "last_name" => $validated_data["last-name"],
                    "email" => $validated_data["email"],
                    "password" => $validated_data["password"]
                ]);
                $this->response->redirect("test/auth");
            }
        }
    }
    public function login()
    {
        if ($this->request->is_post()) {
            $this->request->validate->set_fields_data($this->request->get_fields_data());

            $this->request->validate->field("email")
                ->required("Email required!");
            $this->request->validate->field("password")
                ->required("Password required!");

            $this->request->validate->field("email")
                ->string("Email must be a valid string!")
                ->email("Email must have type of email!")
                ->min_char(6, "Email must be 6 charactor minimum!")
                ->max_char(255, "Email must be 255 charactor maximum!")
                ->exists("users", message: "Tên đăng nhập hoặc mật khẩu không đúng");

            $this->request->validate->field("password")
                ->string("Password must be a valid string!")
                ->min_char(6, "Password must be 6 charactor minimum!")
                ->max_char(20, "Password must be 20 charactor maximum!")
                ->hashed()
                ->exists("users", message: "Tên đăng nhập hoặc mật khẩu không đúng");

            if ($this->request->validate->is_error()) {
                Session::flash("errors", $this->request->validate->get_first_error());
                Session::flash("msg", "Đã có lỗi xảy ra!");
                Session::flash("field_data", $this->request->get_fields_data());
                $this->response->redirect("kiem-tra/dang-nhap");
            } else {
                $validated_data = $this->request->validate->get_fields_data();
                $query = $this->db->table("users")
                    ->where("email", "=", $validated_data["email"])
                    ->where("password", "=", $validated_data["password"])->first();
                if (is_null($query)) {
                    Session::flash("errors", ["Có lỗi xảy ra trong quá trình đăng nhập"]);
                    Session::flash("msg", "Đã có lỗi xảy ra!");
                    Session::flash("field_data", $this->request->get_fields_data());
                    $this->response->redirect("kiem-tra/dang-nhap");
                }
                $this->response->redirect("test/auth");
            }
        }
    }
}
