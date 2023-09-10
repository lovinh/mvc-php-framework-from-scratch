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

function error_handler(
    int $type,
    string $msg,
    ?string $file,
    ?int $line
) {
    echo "MY CUSTOM ERROR HANDLER</br>";
    exit;
}
function shutdown_handler() {
    echo "MY CUSTOM SHUTDOWN HANDLER</br>";
    exit;
}
set_error_handler('error_handler', E_ALL);
register_shutdown_function("shutdown_handler");

// Load routing
require_once "core/Route.php";

// Load app
require_once "app/App.php";

// Load database connection
// Check configuration
if (!empty($database_config)) {
    require_once "core/Connection.php";
    require_once "core/Database.php";
}

// Load app core
require_once "core/BaseModel.php";
require_once "core/BaseController.php";
