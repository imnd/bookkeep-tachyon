<?php

namespace app\controllers;

use app\entities\Client,
    app\models\Settings,
    app\repositories\ClientsRepository,
    app\repositories\BillsRepository,
    app\repositories\InvoicesRepository,
    app\repositories\RegionsRepository,
    tachyon\Request;
use ErrorException;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\HttpException;

/**
 * Контроллер клиентов фирмы
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ClientsController extends CrudController
{
    /**
     * @param ClientsRepository $repository
     * @param array             $params
     */
    public function __construct(ClientsRepository $repository, ...$params)
    {
        $this->repository = $repository;
        parent::__construct(...$params);
    }

    /**
     * @param Client $entity
     *
     * @throws ErrorException
     */
    public function index(Client $entity): void
    {
        $this->doIndex($entity);
    }

    /**
     * @param RegionsRepository $regionRepository
     */
    public function create(RegionsRepository $regionRepository): void
    {
        $this->doCreate(['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param RegionsRepository $regionRepository
     * @param int               $pk
     *
     * @throws HttpException
     */
    public function update(RegionsRepository $regionRepository, int $pk): void
    {
        $this->doUpdate($pk, ['regions' => $regionRepository->findAll()]);
    }

    /**
     * @param BillsRepository    $billRepository
     * @param InvoicesRepository $invoiceRepository
     * @param Settings           $settings
     * @param int                $pk
     *
     * @throws DBALException
     */
    public function printout(
        BillsRepository $billRepository,
        InvoicesRepository $invoiceRepository,
        Settings $settings,
        int $pk
    ): void {
        $this->layout = 'printout';
        $client = $this->repository->findByPk($pk);
        if (empty($getParams = Request::getGet())) {
            $this->view('printout', compact('client'));
            return;
        }
        $where = array_merge(['client_id' => $pk], $getParams);
        $debtSum = $invoiceRepository->getTotalByContract($where);
        $creditSum = $billRepository->getTotalByContract($where);
        $this->view('reconciliation', [
            'client'     => $client,
            'sender'     => $settings->getRequisites('firm'),
            'dateFrom'   => $this->convDateToReadable($getParams['dateFrom']),
            'dateTo'     => $this->convDateToReadable($getParams['dateTo']),
            'bills'      => $billRepository->getAllByContract($where),
            'invoices'   => $invoiceRepository->getAllByContract($where),
            'debtSum'   => number_format($debtSum, 2, '.', ''),
            'creditSum'  => number_format($creditSum, 2, '.', ''),
            'saldo'      => number_format($debtSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0,
        ]);
    }
}
