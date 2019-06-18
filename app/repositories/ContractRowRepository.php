<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\interfaces\ContractRowRepositoryInterface,
    app\entities\ContractRow;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractRowRepository extends Repository implements ContractRowRepositoryInterface
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
