<?php
include('vendor/autoload.php');

//define(APP_DIR, '../../../');

use app\ServiceContainer,
    tachyon\Router;

(new ServiceContainer)
    ->get(Router::class)
    ->dispatch();
