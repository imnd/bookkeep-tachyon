<?php
namespace app;

use tachyon\Request,
    tachyon\dic\Container,
    tachyon\traits\ClassName;

/**
 * Dependency Injection Container
 *
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ServiceContainer extends Container
{
    use ClassName;

    public function boot()
    {
        $controllerName = $this->getClassName(Request::get('controller'));
        $entity = str_replace('Controller', '', $controllerName);
        // сопоставление интерфейсов зависимостей с реализацией
        $this->implementations['app\interfaces\RepositoryInterface'] = "app\\repositories\\{$entity}Repository";
        $this->implementations['app\interfaces\RowsRepositoryInterface'] = "app\\repositories\\{$entity}RowsRepository";
    }
}
