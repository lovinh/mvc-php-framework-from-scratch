<?php

namespace app\core\model;

class PostsModel extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function load_posts()
    {
        return
            $this->db->select("posts", optional: [
                "condition" => "author_id=1 AND category='test'"
            ]);
    }

    public function test_query_builder()
    {
        $data = $this->db->table("users")->order_by("username", True)->get();
        return $data;
    }

    public function test_query_builder_2()
    {
        $data = $this->db->table("posts")->select_field()->where("views", ">=", 0)->where_like("category", "t__%")->limit(3, 2)->order_by("author_id", true)->get();
        return $data;
    }
}
