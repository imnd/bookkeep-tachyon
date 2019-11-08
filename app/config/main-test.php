<?php
$config = require 'main.php';
$config['db'] = require 'db-test.php';
$config['base_url'] = 'http://bookkeep-test/';

return $config;