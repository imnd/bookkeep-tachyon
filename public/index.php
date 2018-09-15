<?php
include('..\\vendor\\tachyon\\autoload.php');

$frontController = \tachyon\dic\Container::getInstanceOf('FrontController');
$frontController->dispatch();
