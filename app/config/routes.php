<?php
$routes = [
    // контроллер по умолчанию
    '/' => 'app\controllers\IndexController@index',
    'error' => 'app\controllers\IndexController@error'
];
foreach (['articles', 'bills', 'clients', 'contracts', 'invoices', 'purchases', 'settings'] as $entity) {
    $controller = 'app\controllers\\' . ucfirst($entity) . "Controller";
    foreach (['index', 'create', 'update', 'delete'] as $action) {
        $routes["/$entity/$action"] = "$controller@$action";
    }
}
return $routes;
