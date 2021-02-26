<?php

namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\entities\Contract,
    tachyon\traits\DateTime,
    tachyon\db\dataMapper\Entity,
    app\entities\Client,
    app\repositories\ClientsRepository
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ContractsRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var Contract
     */
    protected $contract;
    /**
     * @var ClientsRepository
     */
    protected $clientsRepository;

    /**
     * @param Contract $contract
     * @param ClientsRepository $clientsRepository
     * @param array $params
     */
    public function __construct(
        Contract $contract,
        ClientsRepository $clientsRepository,
        ...$params
    ) {
        $this->contract = $contract;
        $this->clientsRepository = $clientsRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return ContractsRepository
     */
    public function setSearchConditions($conditions = []): Repository
    {
        $this->where = $this->setYearBorders($conditions);
        parent::setSearchConditions($conditions);
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function findByPk($pk): ?Entity
    {
        if (!$contract = parent::findByPk($pk)) {
            return null;
        }
        /** @var Client */
        if ($client = $this->clientsRepository->findByPk($contract->getClientId())) {
            $contract
                ->setClientName($client->getName())
                ->setClientContactPost($client->getContactPost())
                ->setClientContactFio($client->getContactFio())
            ;
        }
        return $contract;
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
                'cl.name'            => 'clientName',
                'cl.address'         => 'clientAddress',
                'SUM(i.sum)'         => 'executed',
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
