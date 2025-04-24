<?php
$routes = [
    // контроллер по умолчанию
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
    foreach (['index', 'create'] as $action) {
        $routes["$entity/$action"] = "$controller@$action";
    }
    foreach (['update', 'delete'] as $action) {
        $routes["$entity/$action/{id}"] = "$controller@$action";
    }
}

$routes['invoices/grid'] = 'app\controllers\InvoicesController@grid';

return $routes;
