<?php
include('vendor/autoload.php');

use app\ServiceContainer,
    tachyon\Router;

$_SESSION['app'] = $app = new ServiceContainer;

include('vendor/imnd/tachyon/src/helper_functions.php');

$app
    ->get(Router::class)
    ->dispatch();
