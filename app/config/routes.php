<?php
$routes = [
    '/' => 'app\controllers\IndexController@index', // контроллер по умолчанию
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
    $routes[$entity] = "$controller@index";
    foreach (['index', 'create'] as $action) {
        $routes["$entity/$action"] = "$controller@$action";
    }
    foreach (['update', 'delete'] as $action) {
        $routes["$entity/$action/{pk}"] = "$controller@$action";
    }
}

$routes['invoices/grid'] = 'app\controllers\InvoicesController@grid';

return $routes;
