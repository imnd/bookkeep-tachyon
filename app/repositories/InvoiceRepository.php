<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\repositories\InvoiceRowRepository,
    app\repositories\ClientRepository,
    app\entities\Invoice,
    tachyon\traits\DateTime;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoiceRepository extends HasRowsRepository
{
    use DateTime;

    /**
     * @var app\entities\Invoice
     */
    protected $invoice;
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    public function __construct(
        Invoice $invoice,
        InvoiceRowRepository $rowRepository,
        ClientRepository $clientRepository,
        ...$params
    )
    {
        $this->invoice = $invoice;
        $this->rowRepository = $rowRepository;
        $this->clientRepository = $clientRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return InvoiceRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $conditions = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
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
            ->with([$this->clientRepository->getTableName() => 'cl'], ['client_id' => 'id'])
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

        if (!empty($where['client_id']))
            $this->addWhere(array('cl.id' => $where['client_id']));
        if (!empty($where['contract_num']))
            $this->addWhere(array('cn.contract_num' => $where['contract_num']));
            
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
        $item = $this->findOneRaw();
        if ($value = $item['total']) {
            return $value;
        }
        return 0;
    }

    /**
     * Возвращает последний (максимальный) номер
     * @return integer
     */
    public function getLastNumber(): int
    {
        $item = $this
            ->select('number')
            ->findOneRaw();

        return $item['number'];
    }
}
