<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\traits\DateTime,
    tachyon\db\dataMapper\Entity,
    app\entities\Client,
    app\entities\Invoice;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class InvoicesRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var ContractsRepository
     */
    protected ContractsRepository $contractsRepository;
    /**
     * @var ClientsRepository
     */
    protected ClientsRepository $clientsRepository;

    /**
     * @param Invoice $invoice
     * @param ClientsRepository $clientsRepository
     * @param ContractsRepository $contractsRepository
     * @param array $params
     */
    public function __construct(
        Invoice $invoice,
        ClientsRepository $clientsRepository,
        ContractsRepository $contractsRepository,
        ...$params
    )
    {
        $this->entity = $invoice;
        $this->contractsRepository = $contractsRepository;
        $this->clientsRepository = $clientsRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return InvoicesRepository
     */
    public function setSearchConditions(array $conditions = array()): Repository
    {
        $conditions = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function findByPk($pk): ?Entity
    {
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
                ->setClientKPP($client->getKPP())
            ;
        }
        return $invoice;
    }

    public function findAll(array $where = array(), array $sort = array()): Iterator
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

    /**
     * @inheritdoc
     */
    public function getAllByContract($where = array()): array
    {
        $this
            ->select(array('date', 'number', 'sum'))
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo')
        ;

        if (!empty($where['client_id'])) {
            $this->addWhere(['cl.id' => $where['client_id']]);
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(['cn.contract_num' => $where['contract_num']]);
        }
        return $this->findAllRaw();
    }

    /**
     * @inheritdoc
     */
    public function getTotalByContract($where = array()): int
    {
        $this
            ->asa('i')
            ->select('SUM(i.sum) as total')
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo')
        ;

        if (!empty($where['client_id'])) {
            $this->addWhere(array('cl.id' => $where['client_id']));
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(array('cn.contract_num' => $where['contract_num']));
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
     * @return integer
     */
    public function getLastNumber(): ?int
    {
        $item = $this
            ->select('number')
            ->findOneRaw();

        return $item['number'] ?? null;
    }
}
