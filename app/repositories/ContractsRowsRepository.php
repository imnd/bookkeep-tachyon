<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ContractRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ContractsRowsRepository extends Repository
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
