<?php
namespace app\repositories;

use
    app\interfaces\RowsRepositoryInterface,
    app\entities\InvoiceRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class InvoicesRowsRepository extends RowsRepository implements RowsRepositoryInterface
{
    /**
     * @var InvoiceRow
     */
    protected $invoiceRow;

    public function __construct(InvoiceRow $row, ...$params)
    {
        $this->invoiceRow = $row;

        parent::__construct(...$params);
    }
}
