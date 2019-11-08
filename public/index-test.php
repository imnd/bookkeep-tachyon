<?php
include('..\vendor\autoload.php');

use tachyon\dic\Container,
    tachyon\Config,
    tachyon\Router;

$container = new Container;
$config = $container->get(Config::class, ['env' => 'test']);
$router = $container->get(Router::class, [compact('config')]);

