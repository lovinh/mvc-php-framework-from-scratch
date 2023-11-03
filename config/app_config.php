<?php

/**
 * @var array
 */

use app\core\helper\CustomClass;
use app\core\middleware\AuthMiddleware;
use app\core\middleware\ParamsMiddleware;
use app\core\service\AppServiceProvider;

$app_config = [
    "debug_mode" => true,
    "service" => [
        CustomClass::class,
    ],
    "global_middleware" => [
        ParamsMiddleware::class,
    ],
    "boot" => [
        AppServiceProvider::class,
    ],
];
