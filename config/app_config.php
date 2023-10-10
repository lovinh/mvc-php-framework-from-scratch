<?php

/**
 * @var array
 */
$app_config["debug_mode"] = true;
$app_config["service"] = [
    CustomClass::class
];
$app_config["route_middleware"] = [
    "san-pham" => AuthMiddleware::class,
];
$app_config["global_middleware"] = [
    ParamsMiddleware::class
];
