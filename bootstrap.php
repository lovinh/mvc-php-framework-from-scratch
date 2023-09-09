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

// Load config
require_once "config/routers_config.php";
require_once "config/app_config.php";

// Load routing
require_once "core/Route.php";

// Load app
require_once "app/App.php";

// Load app core
require_once "core/BaseController.php";
