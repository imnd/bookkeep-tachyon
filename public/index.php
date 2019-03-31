<?php
include('..\vendor\tachyon\autoload.php');

(new \tachyon\dic\Container)->get('\tachyon\Router')->dispatch();
