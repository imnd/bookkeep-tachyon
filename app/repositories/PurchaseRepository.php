<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    app\repositories\PurchaseRowRepository,
    app\entities\Purchase
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchaseRepository extends HasRowsRepository
{
    use \tachyon\traits\DateTime;

    /**
     * @var app\entities\Purchase
     */
    protected $purchase;

    /**
     *
     * @param Purchase $purchase
     * @param PurchaseRowRepository $rowRepository
     * @param array $params
     */

    public function __construct(
        Purchase $purchase,
        PurchaseRowRepository $rowRepository,
        ...$params
    )
    {
        $this->purchase = $purchase;
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return PurchaseRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $this->where = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
    }
}
