<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\interfaces\BillRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
    app\entities\Bill;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class BillRepository extends Repository implements BillRepositoryInterface
{
    use \tachyon\traits\DateTime;

    /**
     * @var app\entities\Bill
     */
    protected $bill;
    /**
     * @var ClientRepositoryInterface
     */
    protected $clientRepository;

    public function __construct(Bill $bill, ClientRepositoryInterface $clientRepository, ...$params)
    {
        $this->bill = $bill;
        $this->clientRepository = $clientRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return BillRepository
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
                'b.id',
                'b.contract_num',
                'b.sum',
                'b.remainder',
                'b.date',
                'b.contents',
                'cl.name' => 'clientName'
            ])
            ->from($this->tableName)
            ->asa('b')
            ->with([$this->clientRepository->getTableName() => 'cl'], ['client_id' => 'id'])
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }

    /**
     * @inheritdoc
     */
    public function getAllByContract($where=array()): array
    {
        $this
            ->select(array('date', 'sum'))
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
        return $this->findAllRaw();
    }

    /**
     * @inheritdoc
     */
    public function getTotalByContract($where=array()): int
    {
        $this
            ->asa('b')
            ->select('SUM(b.sum) as total')
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
}
