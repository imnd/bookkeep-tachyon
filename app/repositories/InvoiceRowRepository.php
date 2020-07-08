<?php
namespace app\repositories;

use
    tachyon\db\dataMapper\Repository,
    app\entities\InvoiceRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoiceRowRepository extends Repository
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
