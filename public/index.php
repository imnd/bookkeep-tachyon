<?php
(new \tachyon\FrontController)->dispatch();

function __autoload($className)
{
    $basePath = '..';
	$className = str_replace('\\', '/', $className);
    $autoload = require "$basePath/vendor/tachyon/config/autoload.php";
	foreach ($autoload as $path) {
        $fileName = "$basePath/$path/$className.php";
		if (file_exists($fileName)) {
			include_once($fileName);
			break;
		}
	}
}