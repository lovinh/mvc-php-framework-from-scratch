<?php
class App
{
    private $__controller;
    private $__action;
    private $__parameters;
    private $__route;

    function __construct()
    {
        global $router;

        // Init route object
        $this->__route = new Route();

        if (!empty($router["default_controller"])) {
            $this->__controller = $router["default_controller"];
        }
        $this->__action = "index";
        $this->__parameters = [];

        $this->init($this->parse_url());
    }

    /**
     * This function use to parse an url and assign to class attribute, respectively.
     */
    function parse_url()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = "/";
        }

        // Handle routing
        $url = $this->__route->handle_route($url);

        // This explode() use to seperate a string into substrings by '/' seperator.
        // Example: Home/index/a/b/c/ => ["", "Home", "index", "a", "b", "c", ""]
        // Using array_filter() to remove empty element. From above example, this new array is ["Home", "index", "a", "b", "c"]
        // Using array_value() to reset array index. Now the array start from 0.
        $url_array = array_values(array_filter(explode('/', $url)));

        // Check for meeting file
        $url_check = '';
        if (!empty($url_array)) {
            foreach ($url_array as $key => $url_item) {
                $url_check = strtolower($url_check) . ucfirst($url_item) . '/';
                $file_check = rtrim($url_check, '/');
                if (!empty($url_array[$key - 1])) {
                    unset($url_array[$key - 1]);
                }
                if (file_exists("app/controllers/" . $file_check . ".php")) {
                    $url_check = $file_check;
                    break;
                }
            }
            $url_array = array_values($url_array);
        } else {
            $url_check = $this->__controller;
        }

        // Handle controller
        if (!empty($url_array[0])) {
            $this->__controller = ucfirst($url_array[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        // Handle action
        if (!empty($url_array[1])) {
            $this->__action = ucfirst($url_array[1]);
        } else {
            // placeholder for error handle
        }

        // Handle parameters
        $this->__parameters = array_slice($url_array, 2);

        return $url_check;
    }

    /**
     * This function use to init controller object
     */
    function init($url_check)
    {
        global $app_config;
        // Check for exist controller file. If not, raise error
        if (!file_exists("app/controllers/" . $url_check . ".php")) {
            // Placeholder for error handle
            $this->load_error();
            if ($app_config["debug_mode"])
                throw new Exception("Controller file '" . $this->__controller . "' not exist. Make sure you have created your controller file", 1);
        }

        require_once "app/controllers/" . $url_check . ".php";

        if (!class_exists($this->__controller)) {
            // Check for class $this->__controller exist
            // placeholder for error handle
            if (!$app_config["debug_mode"])
                $this->load_error("500");
            else
                throw new Exception("Controller class '" . $this->__controller . "' not exist. Make sure you name your controller class match with controller file name", 1);
        } else if (!method_exists($this->__controller, $this->__action)) {
            // Check for exist action
            // Placeholder for error handle
            $this->load_error();
            if ($app_config["debug_mode"])
                throw new Exception("Action method not exist. Maybe you missing your action method in your controller class", 1);
        } else {
            $this->__controller = new $this->__controller();


            // This function use to execute a custom function 
            try {
                call_user_func_array([$this->__controller, $this->__action], $this->__parameters);
            } catch (Exception $e) {
                $this->load_error("500");
            }
        }
    }

    /**
     * This function use to load a error page with error name
     */
    public function load_error($name = "404")
    {
        require_once "app/errors/" . $name . ".php";
    }
}
