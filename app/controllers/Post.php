<?php
class Post extends BaseController
{
    public function index()
    {
        $post_model = $this->get_model("PostsModel");
        $posts = $post_model->load_posts();
        echo '<pre>';
        print_r($posts);
        echo '</pre>';
    }
}
