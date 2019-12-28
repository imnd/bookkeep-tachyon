<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\traits\DateTime,
    app\repositories\ContractsRowsRepository,
    app\entities\Contract
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var app\entities\Contract
     */
    protected $contract;

    public function __construct(
        Contract $contract,
        ContractsRowsRepository $rowRepository,
        ...$params
    )
    {
        $this->contract = $contract;
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return ContractsRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $this->where = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
    }

    public function findAll(array $where = array(), array $sort = array()): Iterator
    {
        $arrayData = $this->persistence
            ->select([
                'c.id',
                'c.contract_num',
                'c.sum',
                'c.date',
                'c.term_start',
                'c.term_end',
                'cl.name' => 'clientName',
                'cl.address' => 'clientAddress',
                'SUM(i.sum)' => 'executed',
                'c.sum - SUM(i.sum)' => 'execRemind',
            ])
            ->from($this->tableName)
            ->asa('c')
            ->with(['clients' => 'cl'], ['client_id' => 'id'])
            ->with(['invoices' => 'i'], 'contract_num')
            ->groupBy('c.id, c.contract_num, i.contract_num, c.client_id, cl.id')
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }
}
