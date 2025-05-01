<?php
namespace app;

use app\interfaces\{
    RowsRepositoryInterface,
    RowEntityInterface
};
use tachyon\dic\Container;
use tachyon\db\dataMapper\{
    EntityInterface,
    RepositoryInterface
};
use tachyon\Helpers\ClassHelper;

/**
 * Dependency Injection Container
 *
 * @author imndsu@gmail.com
 */
class ServiceContainer extends Container
{
    public function boot($params = []): Container
    {
        // сопоставление интерфейсов зависимостей с реализацией

        $controllerName = ClassHelper::getClassName($params['controller']);

        $entity = str_replace('Controller', '', $controllerName);
        $this->implementations = array_merge($this->implementations, [
            RowsRepositoryInterface::class => "app\\repositories\\{$entity}RowsRepository",
            RepositoryInterface::class => "app\\repositories\\{$entity}Repository",
        ]);

        $entity = substr($entity, 0, -1);
        $this->implementations = array_merge($this->implementations, [
            RowEntityInterface::class => "app\\entities\\{$entity}Row",
            EntityInterface::class => "app\\entities\\$entity",
        ]);

        return $this;
    }
}
