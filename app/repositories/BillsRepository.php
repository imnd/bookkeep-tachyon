<?php

namespace app\repositories;

use app\traits\ConditionsTrait,
    app\entities\Bill,
    Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\db\dbal\conditions\Terms
;

/**
 * @author imndsu@gmail.com
 */
class BillsRepository extends Repository
{
    use ConditionsTrait;

    protected string $tableAlias = 'b';

    public function __construct(
        Bill $bill,
        protected ClientsRepository $clientsRepository,
        protected Terms $terms,
        ...$params
    ) {
        $this->entity = $bill;

        parent::__construct(...$params);
    }

    public function setSearchConditions(array $conditions = []): Repository
    {
        $conditions = $this->setYearBorders($conditions);

        parent::setSearchConditions($conditions);

        return $this;
    }

    public function findAll(array $where = [], array $sort = []): Iterator
    {
        $arrayData = $this->persistence
            ->select(
                [
                    "{$this->tableAlias}.id",
                    "{$this->tableAlias}.contract_num",
                    "{$this->tableAlias}.sum",
                    "{$this->tableAlias}.remainder",
                    "{$this->tableAlias}.date",
                    "{$this->tableAlias}.contents",
                    'cl.name' => 'clientName',
                ]
            )
            ->from($this->tableName)
            ->asa($this->tableAlias)
            ->with([$this->clientsRepository->getTableName() => 'cl'], ['client_id' => 'id'])
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }

    public function getAllByContract(array $where = []): array
    {
        if (!empty($where['dateFrom']) && preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $where['dateFrom'])) {
            $where['dateFrom'] = \DateTime::createFromFormat('d.m.Y', $where['dateFrom'])->format('Y-m-d');
        }
        if (!empty($where['dateTo']) && preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $where['dateTo'])) {
            $where['dateTo'] = \DateTime::createFromFormat('d.m.Y', $where['dateTo'])->format('Y-m-d');
        }

        $conditions = array_merge(
            $this->terms->gt($where, 'cn.date', 'dateFrom'),
            $this->terms->lt($where, 'cn.date', 'dateTo')
        );

        if (!empty($where['client_id'])) {
            $conditions['cl.id'] = $where['client_id'];
        }
        if (!empty($where['contract_num'])) {
            $conditions['cn.contract_num'] = $where['contract_num'];
        }

        $this->persistence
            ->select(['date', 'sum'])
            ->from($this->tableName)
            ->asa($this->tableAlias)
            ->with(['clients' => 'cl'], ['client_id' => 'id'])
            ->with(['contracts' => 'cn'], ['contract_num' => 'contract_num']);

        return $this->persistence->findAll($conditions);
    }

    public function getTotalByContract(array $where = []): int
    {
        if (!empty($where['dateFrom']) && preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $where['dateFrom'])) {
            $where['dateFrom'] = \DateTime::createFromFormat('d.m.Y', $where['dateFrom'])->format('Y-m-d');
        }
        if (!empty($where['dateTo']) && preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $where['dateTo'])) {
            $where['dateTo'] = \DateTime::createFromFormat('d.m.Y', $where['dateTo'])->format('Y-m-d');
        }

        $conditions = array_merge(
            $this->terms->gt($where, 'cn.date', 'dateFrom'),
            $this->terms->lt($where, 'cn.date', 'dateTo')
        );

        if (!empty($where['client_id'])) {
            $conditions['cl.id'] = $where['client_id'];
        }
        if (!empty($where['contract_num'])) {
            $conditions['cn.contract_num'] = $where['contract_num'];
        }

        $item = $this->persistence
            ->select("SUM({$this->tableAlias}.sum) as total")
            ->from($this->tableName)
            ->asa($this->tableAlias)
            ->with(['clients' => 'cl'], ['client_id' => 'id'])
            ->with(['contracts' => 'cn'], ['contract_num' => 'contract_num'])
            ->findOne($conditions);

        if ($value = $item['total'] ?? null) {
            return (int)$value;
        }
        return 0;
    }

    public function getContentsList(): array
    {
        return [
            'payment' => 'платёж',
            'purchase' => 'закуп',
        ];
    }
}
