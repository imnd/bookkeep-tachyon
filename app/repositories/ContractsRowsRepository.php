<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ContractRow,
    app\interfaces\RowsRepositoryInterface;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsRowsRepository extends Repository implements RowsRepositoryInterface
{
    /**
     * @var app\entities\ContractRow
     */
    protected $contractRow;

    public function __construct(ContractRow $row, ...$params)
    {
        $this->contractRow = $row;

        parent::__construct(...$params);
    }
}
