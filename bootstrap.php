<?php
include('vendor/autoload.php');

use app\ServiceContainer,
    tachyon\Router;

(new ServiceContainer)
    ->get(Router::class)
    ->dispatch();
