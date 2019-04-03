<?php
namespace app\controllers;

use app\entities\Client,
    app\interfaces\ClientRepositoryInterface,
    app\interfaces\RegionRepositoryInterface,
    app\models\Bills,
    app\models\Invoices,
    app\models\Settings
;

/**
 * Контроллер клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */ 
class ClientsController extends CrudController
{
    use \tachyon\traits\Authentication;

    /**
     * @var app\repositories\ClientRepositoryInterface
     */
    protected $repository;

    /**
     * @param ClientRepositoryInterface $repository
     * @param array $params
     */
    public function __construct(ClientRepositoryInterface $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

    /**
     * @param Client $client
     */
    public function index(Client $entity)
    {
        $this->_index($entity);
    }

    /**
     * @param RegionRepositoryInterface $regionRepository
     */
    public function create(RegionRepositoryInterface $regionRepository)
    {
        $this->_create(['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param RegionRepositoryInterface $regionRepository
     * @param int $pk
     */
    public function update(RegionRepositoryInterface $regionRepository, $pk)
    {
        $this->_update($pk, ['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param Bills $bills
     * @param Invoices $invoices
     * @param Settings $settings
     * @param int $pk
     */
    public function printout(Bills $bills, Invoices $invoices, Settings $settings, $pk)
    {
        $this->layout = 'printout';
        $client = $this->repository->findByPk($pk);
        if (empty($this->get)) {
            $this->view('printout', compact('client'));
            return;
        }
        $where = array_merge(array('client_id' => $pk), $this->get);
        $debetSum = $invoices->getTotalByContract($where);
        $creditSum = $bills->getTotalByContract($where);
        $this->view('reconciliation', [
            'client' => $client,
            'sender' => $settings->getRequisites('firm'),
            'dateFrom' => $this->convDateToReadable($this->get['dateFrom']),
            'dateTo' => $this->convDateToReadable($this->get['dateTo']),
            'bills' => $bills->getAllByContract($where),
            'invoices' => $invoices->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ]);
    }
}
