<?php

namespace app\repositories;

use app\traits\ConditionsTrait,
    app\entities\Bill,
    Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\db\dbal\conditions\Terms,
    tachyon\traits\RepositoryListTrait
;

/**
 * @author imndsu@gmail.com
 */
class BillsRepository extends Repository
{
    use RepositoryListTrait, ConditionsTrait;

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
        $this
            ->select(['date', 'sum'])
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

    public function getTotalByContract(array $where = []): int
    {
        $this
            ->asa($this->tableAlias)
            ->select("SUM({$this->tableAlias}.sum) as total")
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
