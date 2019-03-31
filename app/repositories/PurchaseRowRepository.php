<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\interfaces\PurchaseRowRepositoryInterface,
    app\entities\PurchaseRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchaseRowRepository extends Repository implements PurchaseRowRepositoryInterface
{
    /**
     * @var app\entities\PurchaseRow
     */
    protected $purchaseRow;

    public function __construct(PurchaseRow $row, ...$params)
    {
        $this->purchaseRow = $row;

        parent::__construct(...$params);
    }
}
