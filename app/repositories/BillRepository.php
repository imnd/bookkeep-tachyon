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
}
