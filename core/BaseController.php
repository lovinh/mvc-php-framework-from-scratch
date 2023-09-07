<?php
class BaseController
{

    public function get_model($model_name)
    {
        global $app_config;
        if (!file_exists(_DIR_ROOT . "/app/models/" . $model_name . '.php')) {
            // Handle error missing model file
            if ($app_config["debug_mode"]) {
                trigger_error("File model '" . $model_name . ".php' not exist!", E_USER_WARNING);
            }
            throw new ErrorException("File model '" . $model_name . ".php' not exist!");
        }
        require_once _DIR_ROOT . "/app/models/" . $model_name . '.php';
        if (!class_exists($model_name)) {
            // Handle error model class not exist
            if ($app_config["debug_mode"]) {
                trigger_error("File model '" . $model_name . ".php' not exist!", E_USER_WARNING);
            }
            throw new ErrorException("File model '" . $model_name . ".php' not exist!");
        }
        $model = new $model_name();
        return $model;
    }

    public function render_view($view_name, $data = [])
    {
        global $app_config;
        if (!file_exists(_DIR_ROOT . "/app/views/" . $view_name . ".php")) {
            // Handle error if view file not exist
            if ($app_config["debug_mode"]) {
                trigger_error("File view '" . $view_name . ".php' not exist!", E_USER_WARNING);
            }
            throw new ErrorException("File view '" . $view_name . ".php' not exist!");
        }

        require_once _DIR_ROOT . "/app/views/" . $view_name . ".php";
    }
}
