<?php
namespace app\controllers;

use app\entities\Client,
    app\repositories\ClientRepository,
    app\repositories\RegionRepository,
    app\repositories\BillRepository,
    app\repositories\InvoiceRepository,
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
    /**
     * @var app\repositories\ClientRepository
     */
    protected $repository;

    /**
     * @param ClientRepository $repository
     * @param array $params
     */
    public function __construct(ClientRepository $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

    /**
     * @param Client $entity
     */
    public function index(Client $entity)
    {
        $this->_index($entity);
    }

    /**
     * @param RegionRepository $regionRepository
     */
    public function create(RegionRepository $regionRepository)
    {
        $this->_create(['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param RegionRepository $regionRepository
     * @param int $pk
     */
    public function update(RegionRepository $regionRepository, $pk)
    {
        $this->_update($pk, ['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param BillRepository $billRepository
     * @param InvoiceRepository $invoiceRepository
     * @param Settings $settings
     * @param int $pk
     */
    public function printout(
        BillRepository $billRepository,
        InvoiceRepository $invoiceRepository,
        Settings $settings,
        $pk
    )
    {
        $this->layout = 'printout';
        $client = $this->repository->findByPk($pk);
        if (empty($this->get)) {
            $this->view('printout', compact('client'));
            return;
        }
        $where = array_merge(array('client_id' => $pk), $this->get);
        $debetSum = $invoiceRepository->getTotalByContract($where);
        $creditSum = $billRepository->getTotalByContract($where);
        $this->view('reconciliation', [
            'client' => $client,
            'sender' => $settings->getRequisites('firm'),
            'dateFrom' => $this->convDateToReadable($this->get['dateFrom']),
            'dateTo' => $this->convDateToReadable($this->get['dateTo']),
            'bills' => $billRepository->getAllByContract($where),
            'invoices' => $invoiceRepository->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ]);
    }
}
