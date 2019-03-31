<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\interfaces\InvoiceRepositoryInterface,
    app\interfaces\InvoiceRowRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
    app\entities\Invoice
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoiceRepository extends HasRowsRepository implements InvoiceRepositoryInterface
{
    /**
     * @var app\entities\Invoice
     */
    protected $invoice;
    /**
     * @var ClientRepositoryInterface
     */
    protected $clientRepository;

    public function __construct(
        Invoice $invoice,
        InvoiceRowRepositoryInterface $rowRepository,
        ClientRepositoryInterface $clientRepository,
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
            ->groupBy('t.contract_num')
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }
}
