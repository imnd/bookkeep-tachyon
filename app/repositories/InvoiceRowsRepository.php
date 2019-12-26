<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    app\entities\InvoiceRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoiceRowsRepository extends Repository
{
    /**
     * @var app\entities\InvoiceRow
     */
    protected $invoiceRow;
    protected $tableName = 'invoices_rows';

    public function __construct(InvoiceRow $row, ...$params)
    {
        $this->invoiceRow = $row;

        parent::__construct(...$params);
    }
}
