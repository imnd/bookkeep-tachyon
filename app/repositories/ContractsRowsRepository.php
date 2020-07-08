<?php
namespace app\repositories;

use
    app\entities\ContractRow,
    app\interfaces\RowsRepositoryInterface;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ContractsRowsRepository extends RowsRepository implements RowsRepositoryInterface
{
    /**
     * @var ContractRow
     */
    protected $contractRow;

    public function __construct(ContractRow $row, ...$params)
    {
        $this->contractRow = $row;

        parent::__construct(...$params);
    }
}
