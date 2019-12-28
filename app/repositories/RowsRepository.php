<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    tachyon\traits\ClassName,
    app\interfaces\RowEntityInterface,
    app\interfaces\RowsRepositoryInterface;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class RowsRepository extends Repository implements RowsRepositoryInterface
{
    use ClassName;

    /**
     * @param RowEntityInterface $rowEntity
     * @param array $params
     */
    public function __construct(RowEntityInterface $rowEntity, ...$params)
    {
        $this->entity = $rowEntity;

        parent::__construct(...$params);
    }
}
