<?php

/**
 * @var array
 */
$app_config = [
    "debug_mode" => true,
    "service" => [
        CustomClass::class,
    ],
    "route_middleware" => [
        "san-pham" => AuthMiddleware::class,
    ],
    "global_middleware" => [
        ParamsMiddleware::class,
    ],
    "boot" => [
        AppServiceProvider::class,
    ],
];
