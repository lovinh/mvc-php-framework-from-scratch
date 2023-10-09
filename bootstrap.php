<?php
define('_DIR_ROOT', __DIR__);
// Handle http root
// Get web url protocol
if (!empty($_SERVER["HTTPS"]) &&  $_SERVER["HTTPS"] = "on") {
    $web_root = "https://" . $_SERVER["HTTP_HOST"];
} else {
    $web_root = "http://" . $_SERVER["HTTP_HOST"];
}

// Get web root folder
$document_root = implode('\\', explode('/', $_SERVER["DOCUMENT_ROOT"]));
$folder = ltrim(str_replace(strtolower($document_root), '', strtolower(_DIR_ROOT)), '\\');
$web_root = $web_root . '/' . $folder;

// define constant variable for web root
define('_WEB_ROOT', $web_root);

// Load config. 
$config_dir = scandir("config");
if (!empty($config_dir)) {
    foreach ($config_dir as $config_file) {
        if ($config_file != '.' && $config_file != ".." && file_exists('config/' . $config_file)) {
            require_once "config/" . $config_file;
        }
    }
}

// Check for debug mode
if (!$app_config["debug_mode"]) {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}

// Load custom class
if (!empty($app_config["service"])) {
    $all_services = $app_config["service"];
    if (!empty($all_services)) {
        foreach ($all_services as $service) {
            if (file_exists("app/core/$service.php")) {
                require_once "app/core/$service.php";
            }
        }
    }
}

// Load session
require_once "core/Session.php";

// Load middleware
require_once "core/Middleware.php";

if (!empty($app_config["route_middleware"])) {
    $route_middleware_arr = $app_config["route_middleware"];
    foreach ($route_middleware_arr as $route_middleware_item) {
        var_dump($route_middleware_item);
    }
}

// Load routing
require_once "core/Route.php";

// Load app
require_once "app/App.php";

// Load database connection
// Check configuration
if (!empty($database_config)) {
    require_once "core/Connection.php";
    require_once "core/QueryBuilder.php";
    require_once "core/Database.php";
    require_once "core/DB.php";
}

// Load all helper
// Load core helper
$core_helper_dir = scandir("core/helpers");
if (!empty($core_helper_dir)) {
    foreach ($core_helper_dir as $helper_file) {
        if ($helper_file != '.' && $helper_file != ".." && file_exists('core/helpers/' . $helper_file)) {
            require_once "core/helpers/" . $helper_file;
        }
    }
}

// Load user-defined helpers
$helper_dir = scandir("app/helpers");
if (!empty($helper_dir)) {
    foreach ($helper_dir as $helper_file) {
        if ($helper_file != '.' && $helper_file != ".." && file_exists('app/helpers/' . $helper_file)) {
            require_once "app/helpers/" . $helper_file;
        }
    }
}


// Load app core

// Load Interface
$interface_dir = scandir("core/interfaces");
if (!empty($interface_dir)) {
    foreach ($interface_dir as $interface_file) {
        if ($interface_file != '.' && $interface_file != ".." && file_exists('core/interfaces/' . $interface_file)) {
            require_once "core/interfaces/" . $interface_file;
        }
    }
}

// Load base model
require_once "core/BaseModel.php";

// Load base controller
require_once "core/BaseController.php";

// Load DefinedRules
require_once "core/DefinedRules.php";

// Load validator
require_once "core/Validator.php";

// Load custom rule (if need)
if ($validate_config["apply_custom_rule"]) {
    $rule_dir = scandir("app/rules");
    if (!empty($rule_dir)) {
        foreach ($rule_dir as $rule_file) {
            if ($rule_file != '.' && $rule_file != ".." && file_exists('app/rules/' . $rule_file)) {
                require_once "app/rules/" . $rule_file;
            }
        }
    }
}

// Load request, response
require_once "core/Request.php";
require_once "core/Response.php";
