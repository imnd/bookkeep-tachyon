<?php
namespace app;

use tachyon\Request;
use tachyon\dic\Container;

/**
 * Dependency Injection Container
 *
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ServiceContainer extends Container
{
    public function boot()
    {
        $controllerClass = Request::get('controller');
        $controllerName = substr($controllerClass, strrpos($controllerClass, '\\') + 1);
        $entity = str_replace('Controller', '', $controllerName);
        // сопоставление интерфейсов зависимостей с реализацией
        $this->implementations['app\interfaces\RepositoryInterface'] = "app\\repositories\\{$entity}Repository";
    }
}
