<?php
namespace app\controllers;

use tachyon\Controller,
    app\entities\Client,
    app\repositories\ClientRepository,
    app\repositories\RegionRepository,
    app\models\Bills,
    app\models\Invoices,
    app\models\Settings
;

/**
 * Контроллер клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ClientsController extends Controller
{
    use \tachyon\traits\Authentication;

    protected $layout = 'clients';
    protected $defaultAction = 'list';

    /**
     * @var app\repositories\ClientRepository
     */
    protected $clientRepository;
    /**
     * @var app\repositories\RegionRepository
     */
    protected $regionRepository;

    /**
     * @param ClientRepository $clientRepository
     * @param RegionRepository $regionRepository
     */
    public function __construct(
        ClientRepository $clientRepository,
        RegionRepository $regionRepository,
        ...$params
    )
    {
        $this->clientRepository = $clientRepository;
        $this->regionRepository = $regionRepository;

        parent::__construct(...$params);
    }

    /**
     * @param Client $client
     */
    public function list(Client $client)
    {
        $this->layout('list', [
            'entity' => $client,
            'clients' => $this
                ->clientRepository
                ->setSearchConditions($this->get)
                ->setSort($this->get)
                ->findAll(),
        ]);
    }

    public function create()
    {
        /**
         * @var Client $client
         */
        $client = $this->clientRepository->create();
        $this->save($client);
        $this->layout('create', [
            'client' => $client,
            'regions' => $this->regionRepository->findAll()
        ]);
    }

    /**
     * @param int $pk
     */
    public function update($pk)
    {
        /**
         * @var Client $client
         */
        if (!$client = $this->clientRepository->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        $this->save($client);
        $this->layout('update', [
            'client' => $client,
            'regions' => $this->regionRepository->findAll()
        ]);
    }

    /**
     * @param Client $client
     * @return void
     */
    protected function save(Client $client)
    {
        if (!empty($this->post)) {
            $client->setAttributes($this->post['Client'] ?? $this->post);
            if ($client->validate()) {
                if ($client->getDbContext()->commit()) {
                    $this->flash->setFlash('Сохранено успешно', self::FLASH_TYPE_SUCCESS);
                    $this->redirect("/{$this->id}");
                }
            }
            $this->message = "Что то пошло не так, {$client->getErrorsSummary()}";
        }
    }

    /**
     * @param int $pk
     */
    public function delete($pk)
    {
        if (!$client = $this->clientRepository->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        echo json_encode([
            'success' => $this->clientRepository
                ->findByPk($pk)
                ->delete()
        ]);
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
        $client = $this->clientRepository->findByPk($pk);
        if (empty($this->get)) {
            $this->layout('printout', compact('client'));
            return;
        }
        $where = array_merge(array('client_id' => $pk), $this->get);
        $debetSum = $invoices->getTotalByContract($where);
        $creditSum = $bills->getTotalByContract($where);
        $this->layout('reconciliation', [
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