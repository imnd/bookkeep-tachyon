<?php
include('..\vendor\autoload.php');

use tachyon\dic\Container,
    tachyon\Router;

(new Container)->get(Router::class)->dispatch();
