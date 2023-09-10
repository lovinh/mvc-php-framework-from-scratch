<?php
class PostsModel extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function load_posts()
    {
        return $this->db->query("SELECT * FROM posts")->fetch_all(MYSQLI_ASSOC);
    }
}
