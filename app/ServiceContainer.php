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
        $this->implementations['app\interfaces\RowsRepositoryInterface'] = "app\\repositories\\{$entity}RowsRepository";
        $this->implementations['tachyon\db\dataMapper\RepositoryInterface'] = "app\\repositories\\{$entity}Repository";

        $entity = substr($entity, 0, -1);
        $this->implementations['app\interfaces\RowEntityInterface'] = "app\\entities\\{$entity}Row";
        $this->implementations['tachyon\db\dataMapper\EntityInterface'] = "app\\entities\\{$entity}";
    }
}
