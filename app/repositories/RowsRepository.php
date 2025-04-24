<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\interfaces\RowEntityInterface;

/**
 * @author imndsu@gmail.com
 */
class RowsRepository extends Repository
{
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
