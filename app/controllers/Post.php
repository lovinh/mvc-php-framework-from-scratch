<?php

namespace app\core\controller;

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
    public function test()
    {
        $post_model = $this->get_model("PostsModel");
        $data = $post_model->test_query_builder();
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        // $data = $post_model->test_query_builder_2();
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
    }
}
