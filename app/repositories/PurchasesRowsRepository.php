<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    app\entities\PurchaseRow,
    app\interfaces\RowsRepositoryInterface;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchasesRowsRepository extends Repository implements RowsRepositoryInterface
{
    /**
     * @var app\entities\PurchaseRow
     */
    protected $purchaseRow;
    protected $tableName = 'purchases_rows';

    public function __construct(PurchaseRow $row, ...$params)
    {
        $this->purchaseRow = $row;

        parent::__construct(...$params);
    }
}
