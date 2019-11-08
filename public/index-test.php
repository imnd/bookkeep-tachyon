<?php
include('..\vendor\autoload.php');

use tachyon\dic\Container,
    tachyon\Config,
    tachyon\Router;

$container = new Container;
$config = $this->config = $container->get(Config::class, [
    'fileName' => 'main-test'
]);
$container->get(Router::class, [compact('config')])->dispatch();
