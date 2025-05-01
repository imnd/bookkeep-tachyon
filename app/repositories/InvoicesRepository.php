<?php

namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Entity,
    app\entities\Client,
    app\entities\Invoice
;
use tachyon\db\dbal\conditions\Terms;
use tachyon\helpers\DateTimeHelper;

/**
 * @author imndsu@gmail.com
 */
class InvoicesRepository extends HasRowsRepository
{
    public function __construct(
        Invoice $invoice,
        protected ClientsRepository $clientsRepository,
        protected ContractsRepository $contractsRepository,
        protected Terms $terms,
        ...$params
    ) {
        $this->entity = $invoice;
        parent::__construct(...$params);
    }

    public function setSearchConditions(array $conditions = []): static
    {
        $conditions = $this->setYearBorders($conditions);
        parent::setSearchConditions($conditions);

        return $this;
    }

    public function findByPk(mixed $pk): ?Entity
    {
        /** @var Invoice */
        if (!$invoice = parent::findByPk($pk)) {
            return null;
        }
        if ($contract = $this->contractsRepository
            ->findOne(['contract_num' => $invoice->getContractNum()])) {
            $invoice->setContractType($contract->getType());
        }
        /** @var Client */
        if ($client = $this->clientsRepository
            ->findByPk($invoice->getClientId())) {
            $invoice
                ->setClientName($client->getName())
                ->setClientAddress($client->getAddress())
                ->setClientAccount($client->getAccount())
                ->setClientBank($client->getBank())
                ->setClientINN($client->getINN())
                ->setClientKPP($client->getKPP());
        }
        return $invoice;
    }

    public function findAll(array $where = [], array $sort = []): Iterator
    {
        $arrayData = $this->persistence
            ->select([
                't.id',
                't.number',
                't.contract_num',
                't.sum',
                't.date',
                't.payed',
                'cl.name' => 'clientName',
                'cl.address' => 'clientAddress',
            ])
            ->from($this->tableName)
            ->with(['clients' => 'cl'], ['client_id' => 'id'])
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }

    public function getAllByContract($where = []): array
    {
        $this
            ->select(['date', 'number', 'sum'])
            ->join(['clients' => 'cl'], ['client_id', 'id'])
            ->join(['contracts' => 'cn'], ['contract_num', 'contract_num'])
            ->terms->gt($where, 'cn.date', 'dateFrom')
            ->terms->lt($where, 'cn.date', 'dateTo');

        if (!empty($where['client_id'])) {
            $this->addWhere(['cl.id' => $where['client_id']]);
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(['cn.contract_num' => $where['contract_num']]);
        }
        return $this->findAllRaw();
    }

    public function getTotalByContract($where = []): int
    {
        $this
            ->asa('i')
            ->select('SUM(i.sum) as total')
            ->join(['clients' => 'cl'], ['client_id', 'id'])
            ->join(['contracts' => 'cn'], ['contract_num', 'contract_num'])
            ->terms->gt($where, 'cn.date', 'dateFrom')
            ->terms->lt($where, 'cn.date', 'dateTo');

        if (!empty($where['client_id'])) {
            $this->addWhere(['cl.id' => $where['client_id']]);
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(['cn.contract_num' => $where['contract_num']]);
        }
        if (!$item = $this->findOneRaw()) {
            return 0;
        }
        if ($value = $item['total']) {
            return $value;
        }

        return 0;
    }

    /**
     * Возвращает последний (максимальный) номер
     */
    public function getLastNumber(): ?int
    {
        $item = $this
            ->select('number')
            ->findOneRaw();

        return $item['number'] ?? null;
    }
}
