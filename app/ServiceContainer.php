<?php
namespace app;

use tachyon\Request,
    tachyon\dic\Container,
    tachyon\traits\ClassName;
use app\interfaces\{
    RowsRepositoryInterface, RowEntityInterface
};
use tachyon\db\dataMapper\{
    EntityInterface, RepositoryInterface
};

/**
 * Dependency Injection Container
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ServiceContainer extends Container
{
    use ClassName;

    public function boot(): Container
    {
        $controllerName = $this->getClassName(Request::get('controller'));
        $entity = str_replace('Controller', '', $controllerName);

        // сопоставление интерфейсов зависимостей с реализацией
        $this->implementations[RowsRepositoryInterface::class] = "app\\repositories\\{$entity}RowsRepository";
        $this->implementations[RepositoryInterface::class] = "app\\repositories\\{$entity}Repository";

        $entity = substr($entity, 0, -1);
        $this->implementations[RowEntityInterface::class] = "app\\entities\\{$entity}Row";
        $this->implementations[EntityInterface::class] = "app\\entities\\{$entity}";

        return $this;
    }
}
