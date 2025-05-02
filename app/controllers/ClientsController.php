<?php

namespace app\controllers;

use app\entities\Client,
    app\models\Settings;
use app\repositories\{
        ClientsRepository, BillsRepository, InvoicesRepository, RegionsRepository,
    };
use tachyon\helpers\DateTimeHelper;

/**
 * Контроллер клиентов фирмы
 *
 * @author imndsu@gmail.com
 */
class ClientsController extends CrudController
{
    public function __construct(ClientsRepository $repository, ...$params)
    {
        $this->repository = $repository;
        parent::__construct(...$params);
    }

    public function index(Client $entity): void
    {
        $this->doIndex($entity);
    }

    public function create(RegionsRepository $regionRepository): void
    {
        $this->doCreate(['regions' => $regionRepository->findAll()]);
    }

    public function update(RegionsRepository $regionRepository, int $pk): void
    {
        $this->doUpdate($pk, ['regions' => $regionRepository->findAll()]);
    }

    public function printout(
        BillsRepository $billRepository,
        InvoicesRepository $invoiceRepository,
        Settings $settings,
        int $pk
    ): void {
        $this->layout = 'printout';
        $client = $this->repository->findByPk($pk);
        if (empty($getParams = $this->request->getGet())) {
            $this->view('printout', compact('client'));
            return;
        }
        $where = array_merge(['client_id' => $pk], $getParams);
        $debtSum = $invoiceRepository->getTotalByContract($where);
        $creditSum = $billRepository->getTotalByContract($where);
        $this->view('reconciliation', [
            'client'     => $client,
            'sender'     => $settings->getRequisites('firm'),
            'dateFrom'   => DateTimeHelper::convDateToReadable($getParams['dateFrom']),
            'dateTo'     => DateTimeHelper::convDateToReadable($getParams['dateTo']),
            'bills'      => $billRepository->getAllByContract($where),
            'invoices'   => $invoiceRepository->getAllByContract($where),
            'debtSum'   => number_format($debtSum, 2, '.', ''),
            'creditSum'  => number_format($creditSum, 2, '.', ''),
            'saldo'      => number_format($debtSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0,
        ]);
    }
}
