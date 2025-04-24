<?php
namespace app;

use app\interfaces\{
    RowsRepositoryInterface,
    RowEntityInterface
};
use tachyon\dic\Container,
    tachyon\traits\ClassName;
use tachyon\db\dataMapper\{
    EntityInterface,
    RepositoryInterface
};

/**
 * Dependency Injection Container
 *
 * @author imndsu@gmail.com
 */
class ServiceContainer extends Container
{
    use ClassName;

    public function boot($params = []): Container
    {
        $controllerName = $this->getClassName($params['controller']);

        $entity = str_replace('Controller', '', $controllerName);
        // сопоставление интерфейсов зависимостей с реализацией
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
