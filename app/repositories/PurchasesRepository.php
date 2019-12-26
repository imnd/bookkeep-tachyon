<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    tachyon\traits\DateTime,
    app\repositories\PurchaseRowsRepository,
    app\entities\Purchase
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchasesRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var app\entities\Purchase
     */
    protected $purchase;

    /**
     * @param Purchase $purchase
     * @param PurchaseRowsRepository $rowRepository
     * @param array $params
     */
    public function __construct(
        Purchase $purchase,
        PurchaseRowsRepository $rowRepository,
        ...$params
    )
    {
        $this->purchase = $purchase;
        $this->rowRepository = $rowRepository;

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
