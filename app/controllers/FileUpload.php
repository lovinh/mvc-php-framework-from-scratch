<?php

namespace app\core\controller;

use app\core\http_context\Request;
use app\core\http_context\Response;
use app\core\Session;
use app\core\utils\FileUpload as UtilsFileUpload;
use app\core\view\View;

class FileUpload extends BaseController
{
    public function index()
    {

        echo '<pre>';
        print_r(Session::flash('errors'));
        echo '</pre>';
        echo '<pre>';
        print_r(Session::flash('image'));
        echo '</pre>';

        return View::render("file/index");
    }

    public function upload()
    {
        // do something;
        $this->request->validate->set_fields_data($this->request->get_fields_data());
        $this->request->validate->field('email')
            ->required()
            ->email()
            ->min_char(8);
        $this->request->validate->field('address')
            ->required()
            ->max_char(256)
            ->unicode();
        $this->request->validate->field('age')
            ->required()
            ->integer()
            ->greater_than_or_equal(0)
            ->less_than_or_equal(100);
        $this->request->validate->field('image')
            ->required()
            ->file()
            ->image()
            ->max_byte(5242880);

        if ($this->request->validate->is_error()) {
            Session::flash("errors", $this->request->validate->get_errors());
            Session::flash("image", $this->request->validate->get_field_data('image'));
        }

        $this->response->redirect("file-upload");
        exit;
    }
}
