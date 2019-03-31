<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\interfaces\InvoiceRowRepositoryInterface,
    app\entities\InvoiceRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoiceRowRepository extends Repository implements InvoiceRowRepositoryInterface
{
    /**
     * @var app\entities\InvoiceRow
     */
    protected $invoiceRow;

    public function __construct(InvoiceRow $row, ...$params)
    {
        $this->invoiceRow = $row;

        parent::__construct(...$params);
    }
}
