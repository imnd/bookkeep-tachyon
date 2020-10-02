<?php
namespace app\repositories;

use Iterator,
    tachyon\traits\DateTime,
    tachyon\db\dataMapper\Repository,
    app\entities\Bill,
    tachyon\traits\RepositoryListTrait
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class BillsRepository extends Repository
{
    use DateTime, RepositoryListTrait;

    /**
     * @var ClientsRepository
     */
    protected $clientRepository;

    /**
     * @param Bill $bill
     * @param ClientsRepository $clientsRepository
     * @param array $params
     */
    public function __construct(
        Bill $bill,
        ClientsRepository $clientsRepository,
        ...$params
    )
    {
        $this->entity = $bill;
        $this->clientRepository = $clientsRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return BillsRepository
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

    /**
     * @return array
     */
    public function getContentsList()
    {
        return array(
            'payment' => 'платёж',
            'purchase' => 'закуп',
        );
    }
}
