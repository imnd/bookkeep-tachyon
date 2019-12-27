<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\repositories\ContractsRowsRepository,
    app\repositories\ClientsRepository,
    app\repositories\InvoicesRepository,
    app\entities\Contract
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsRepository extends HasRowsRepository
{
    use \tachyon\traits\DateTime;

    /**
     * @var app\entities\Contract
     */
    protected $contract;
    /**
     * @var ClientsRepository
     */
    protected $clientRepository;
    /**
     * @var InvoicesRepository
     */
    protected $invoiceRepository;

    public function __construct(
        Contract $contract,
        ContractsRowsRepository $rowRepository,
        ClientsRepository $clientRepository,
        InvoicesRepository $invoiceRepository,
        ...$params
    )
    {
        $this->contract = $contract;
        $this->clientRepository = $clientRepository;
        $this->invoiceRepository = $invoiceRepository;
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
            ->with([$this->clientRepository->getTableName() => 'cl'], ['client_id' => 'id'])
            ->with([$this->invoiceRepository->getTableName() => 'i'], 'contract_num')
            ->groupBy('c.id, c.contract_num, i.contract_num, c.client_id, cl.id')
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }
}
