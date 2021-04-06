<?php

namespace app\repositories;

use Iterator,
    tachyon\traits\DateTime,
    tachyon\db\dataMapper\Repository,
    app\entities\Bill,
    tachyon\traits\RepositoryListTrait;

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
    protected ClientsRepository $clientRepository;

    /**
     * @param Bill              $bill
     * @param ClientsRepository $clientsRepository
     * @param array             $params
     */
    public function __construct(
        Bill $bill,
        ClientsRepository $clientsRepository,
        ...$params
    ) {
        $this->entity = $bill;
        $this->clientRepository = $clientsRepository;
        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     *
     * @return BillsRepository
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
            ->select(
                [
                    'b.id',
                    'b.contract_num',
                    'b.sum',
                    'b.remainder',
                    'b.date',
                    'b.contents',
                    'cl.name' => 'clientName',
                ]
            )
            ->from($this->tableName)
            ->asa('b')
            ->with([$this->clientRepository->getTableName() => 'cl'], ['client_id' => 'id'])
            ->findAll($where, $sort);
        return $this->convertArrayData($arrayData);
    }

    /**
     * @param array $where
     *
     * @return array
     */
    public function getAllByContract(array $where = []): array
    {
        $this
            ->select(['date', 'sum'])
            ->join(['clients' => 'cl'], ['client_id', 'id'])
            ->join(['contracts' => 'cn'], ['contract_num', 'contract_num'])
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo');

        if (!empty($where['client_id'])) {
            $this->addWhere(['cl.id' => $where['client_id']]);
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(['cn.contract_num' => $where['contract_num']]);
        }
        return $this->findAllRaw();
    }

    /**
     * @param array $where
     *
     * @return array
     */
    public function getTotalByContract($where = []): int
    {
        $this
            ->asa('b')
            ->select('SUM(b.sum) as total')
            ->join(['clients' => 'cl'], ['client_id', 'id'])
            ->join(['contracts' => 'cn'], ['contract_num', 'contract_num'])
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo');
        if (!empty($where['client_id'])) {
            $this->addWhere(['cl.id' => $where['client_id']]);
        }
        if (!empty($where['contract_num'])) {
            $this->addWhere(['cn.contract_num' => $where['contract_num']]);
        }
        $item = $this->findOneRaw();
        if ($value = $item['total'] ?? null) {
            return $value;
        }
        return 0;
    }

    /**
     * @return array
     */
    public function getContentsList(): array
    {
        return [
            'payment' => 'платёж',
            'purchase' => 'закуп',
        ];
    }
}
