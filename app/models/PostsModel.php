<?php
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
        $data = $this->db->table("posts")->select_field("id, author_id, title")->where("category", "=", "test")->orwhere("id", ">", 3)->where("views", ">=", 0)->get();
        return $data;
    }
}
