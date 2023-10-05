<?php
class TestValidator extends BaseController
{
    private $data = [];
    public function index()
    {
        if ($this->request->is_post()) {
            $this->data = $this->request->get_fields_data();
            $this->request->validate->set_fields_data($this->data);

            $this->request->validate->field("username")
                ->required()
                ->string()
                ->unique("users")
                ->where(fn (Database $query) => $query->where("id", ">", 1));

            $this->request->validate->field("test2")
                ->required()
                ->integer()
                ->exists("users", "username");

            $data["errors"] = $this->request->validate->get_errors();
            $data["data"] = $this->request->validate->get_fields_data();
        } else {
            $data["errors"] = null;
            $data["data"] = null;
        }
        return $this->render_view("testValidator/index", $data);
    }
}
