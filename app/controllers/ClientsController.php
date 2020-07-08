<?php
namespace app\controllers;

use app\entities\Client,
    app\models\Settings,
    app\repositories\ClientsRepository,
    app\repositories\BillsRepository,
    app\repositories\InvoicesRepository,
    app\repositories\RegionsRepository,
    tachyon\Request
;

/**
 * Контроллер клиентов фирмы
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ClientsController extends CrudController
{
    /**
     * @var ClientsRepository
     */
    protected $repository;

    /**
     * @param ClientsRepository $repository
     * @param array $params
     */
    public function __construct(ClientsRepository $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

    /**
     * @param Client $entity
     */
    public function index(Client $entity)
    {
        $this->doIndex($entity);
    }

    /**
     * @param RegionsRepository $regionRepository
     */
    public function create(RegionsRepository $regionRepository)
    {
        $this->doCreate(['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param RegionsRepository $regionRepository
     * @param int $pk
     */
    public function update(RegionsRepository $regionRepository, $pk)
    {
        $this->doUpdate($pk, ['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param BillsRepository $billRepository
     * @param InvoicesRepository $invoiceRepository
     * @param Settings $settings
     * @param int $pk
     */
    public function printout(
        BillsRepository $billRepository,
        InvoicesRepository $invoiceRepository,
        Settings $settings,
        $pk
    )
    {
        $this->layout = 'printout';
        $client = $this->repository->findByPk($pk);
        if (empty($getParams = Request::getGet())) {
            $this->view('printout', compact('client'));
            return;
        }
        $where = array_merge(array('client_id' => $pk), $getParams);
        $debetSum = $invoiceRepository->getTotalByContract($where);
        $creditSum = $billRepository->getTotalByContract($where);
        $this->view('reconciliation', [
            'client' => $client,
            'sender' => $settings->getRequisites('firm'),
            'dateFrom' => $this->convDateToReadable($getParams['dateFrom']),
            'dateTo' => $this->convDateToReadable($getParams['dateTo']),
            'bills' => $billRepository->getAllByContract($where),
            'invoices' => $invoiceRepository->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ]);
    }
}
