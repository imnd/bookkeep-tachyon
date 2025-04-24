<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    tachyon\traits\DateTime,
    app\entities\Purchase;

/**
 * @author imndsu@gmail.com
 */
class PurchasesRepository extends HasRowsRepository
{
    use DateTime;
 
    /**
     * @param Purchase $purchase
     * @param array $params
     */
    public function __construct(Purchase $purchase, ...$params)
    {
        $this->entity = $purchase;

        parent::__construct(...$params);
    }
 
    /**
     * @param array $conditions условия поиска
     * @return PurchasesRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $this->where = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
    }
}
