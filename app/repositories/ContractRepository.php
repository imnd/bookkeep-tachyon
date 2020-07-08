<?php

namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\entities\Contract,
    tachyon\traits\DateTime;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var Contract
     */
    protected $contract;
    /**
     * @var ClientRepository
     */
    protected $clientRepository;
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct(
        Contract $contract,
        ContractRowRepository $rowRepository,
        ClientRepository $clientRepository,
        InvoiceRepository $invoiceRepository,
        ...$params
    ) {
        $this->contract = $contract;
        $this->clientRepository = $clientRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->rowRepository = $rowRepository;
        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     *
     * @return ContractRepository
     */
    public function setSearchConditions($conditions = []): Repository
    {
        $this->where = $this->setYearBorders($conditions);
        parent::setSearchConditions($conditions);
        return $this;
    }

    public function findAll(array $where = [], array $sort = []): Iterator
    {
        $arrayData = $this->persistence
            ->select([
                'c.id',
                'c.contract_num',
                'c.sum',
                'c.date',
                'c.term_start',
                'c.term_end',
                'cl.name'            => 'clientName',
                'cl.address'         => 'clientAddress',
                'SUM(i.sum)'         => 'executed',
                'c.sum - SUM(i.sum)' => 'execRemind',
            ])
            ->from($this->tableName)
            ->asa('c')
            ->with([$this->clientRepository->getTableName() => 'cl'], ['client_id' => 'id'])
            ->with([$this->invoiceRepository->getTableName() => 'i'], 'contract_num')
            ->groupBy('c.contract_num')
            ->findAll($where, $sort);
        return $this->convertArrayData($arrayData);
    }
}
