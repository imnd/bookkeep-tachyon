<?php

namespace app\repositories;

use Iterator,
    app\entities\Contract,
    app\entities\Client,
    tachyon\db\dataMapper\Repository,
    tachyon\db\dataMapper\Entity
;

/**
 * @author imndsu@gmail.com
 */
class ContractsRepository extends HasRowsRepository
{
    public function __construct(
        Contract $contract,
        protected ClientsRepository $clientsRepository,
        ...$params
    ) {
        $this->entity = $contract;

        parent::__construct(...$params);
    }

    public function setSearchConditions(array $conditions = []): Repository
    {
        $conditions = $this->setYearBorders($conditions, 'c');

        parent::setSearchConditions($conditions);

        return $this;
    }

    public function findByPk(mixed $pk): ?Entity
    {
        if (!$contract = parent::findByPk($pk)) {
            return null;
        }
        /** @var Client */
        if ($client = $this->clientsRepository->findByPk($contract->getClientId())) {
            $contract
                ->setClientName($client->getName())
                ->setClientContactPost($client->getContactPost())
                ->setClientContactFio($client->getContactFullName());
        }
        return $contract;
    }

    public function findAll(array $where = [], array $sort = []): Iterator
    {
        $arrayData = $this->persistence
            ->select(
                [
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
                ]
            )
            ->from($this->tableName)
            ->asa('c')
            ->with(['clients' => 'cl'], ['client_id' => 'id'])
            ->with(['invoices' => 'i'], 'contract_num')
            ->groupBy('c.id, c.contract_num, i.contract_num, c.client_id, cl.id')
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }
}
