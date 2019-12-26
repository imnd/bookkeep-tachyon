<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Client,
    app\repositories\RegionsRepository,
    app\repositories\BillsRepository,
    app\repositories\InvoicesRepository,
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
     * @param Client $entity
     */
    public function index(Client $entity)
    {
        $this->_index($entity);
    }

    /**
     * @param RegionsRepository $regionRepository
     */
    public function create(RegionsRepository $regionRepository)
    {
        $this->_create(['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param RegionsRepository $regionRepository
     * @param int $pk
     */
    public function update(RegionsRepository $regionRepository, $pk)
    {
        $this->_update($pk, ['regions' => $regionRepository->findAll()]);
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
