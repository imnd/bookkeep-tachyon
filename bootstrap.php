<?php

require __DIR__ . '/vendor/autoload.php';

use app\ServiceContainer,
    tachyon\FrontController;

$_SESSION['app'] = $app = new ServiceContainer;

require __DIR__ . '/vendor/imnd/tachyon/src/helper_functions.php';

$app
    ->get(FrontController::class)
    ->dispatch();
