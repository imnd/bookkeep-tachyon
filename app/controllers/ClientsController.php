<?php
namespace app\controllers;

use 
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
class ClientsController extends \app\components\CrudController
{
    /**
     * @var app\entities\Client
     */
    protected $client;
    /**
     * @var app\repositories\ClientRepository
     */
    protected $clientRepository;
    /**
     * @var app\repositories\RegionRepository
     */
    protected $regionRepository;
    /**
     * @var app\models\Bills
     */
    protected $bills;
    /**
     * @var app\models\Invoices
     */
    protected $invoices;
    /**
     * @var app\models\Settings
     */
    protected $settings;

    public function __construct(
        Client $client,
        ClientRepository $clientRepository,
        RegionRepository $regionRepository,
        Bills $bills,
        Invoices $invoices,
        Settings $settings,
        ...$params
    )
    {
        $this->client = $client;
        $this->clientRepository = $clientRepository;
        $this->regionRepository = $regionRepository;
        $this->bills = $bills;
        $this->invoices = $invoices;
        $this->settings = $settings;

        parent::__construct(...$params);
    }

    public function init()
    {
        parent::init();

        // переместить в шаблон
        $this->mainMenu['/regions'] = 'районы';
    }

    public function list()
    {
        $this->layout('list', [
            'entity' => $this->client,
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

    public function printout($pk)
    {
        $this->layout = 'printout';
        $client = $this->model->findByPk($pk);
        if (empty($this->get)) {
            $this->layout('printout', compact('client'));
            return;
        }
        $where = array_merge(array('client_id' => $pk), $this->get);
        $debetSum = $this->invoices->getTotalByContract($where);
        $creditSum = $this->bills->getTotalByContract($where);
        $this->layout('reconciliation', array(
            'client' => $client,
            'sender' => $this->settings->getRequisites('firm'),
            'dateFrom' => $this->dateTime->convDateToReadable($this->get['dateFrom']),
            'dateTo' => $this->dateTime->convDateToReadable($this->get['dateTo']),
            'bills' => $this->bills->getAllByContract($where),
            'invoices' => $this->invoices->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ));
    }
}