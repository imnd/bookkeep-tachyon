<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    app\interfaces\PurchaseRepositoryInterface,
    app\interfaces\PurchaseRowRepositoryInterface,
    app\entities\Purchase
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchaseRepository extends HasRowsRepository implements PurchaseRepositoryInterface
{
    use \tachyon\traits\DateTime;

    /**
     * @var app\entities\Purchase
     */
    protected $purchase;
    /**
     * @var ClientRepositoryInterface
     */

    public function __construct(
        Purchase $purchase,
        PurchaseRowRepositoryInterface $rowRepository,
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
