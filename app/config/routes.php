<?php
$routes = [
    '/' => 'app\controllers\IndexController@index',
    'login' => 'app\controllers\IndexController@login',
    'logout' => 'app\controllers\IndexController@logout',
    'error' => 'app\controllers\IndexController@index',
];
foreach ([
    'articles',
    'bills',
    'clients',
    'contracts',
    'invoices',
    'purchases',
    'settings'
] as $entity) {
    $controller = 'app\controllers\\' . ucfirst($entity) . 'Controller';
    foreach (['index', 'create', 'update', 'delete'] as $action) {
        $routes["$entity/$action"] = "$controller@$action";
    }
}
return $routes;
