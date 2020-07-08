<?php
include('..\vendor\autoload.php');

(new \tachyon\dic\Container)->get('\tachyon\Router')->dispatch();
