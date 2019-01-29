<?php
namespace app\controllers;

use app\entities\Client;
use tachyon\helpers\FlashHelper;

/**
 * Контроллер клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ClientsController extends \app\components\CrudController
{
    use \app\dic\ClientRepository;
    use \app\dic\Client;
    use \app\dic\RegionRepository;

    public function init()
    {
        parent::init();
        $this->mainMenu['/regions'] = 'районы';
    }

    public function index()
    {
        $this->layout('index', array(
            'entity' => $this->client,
            'clients' => $this->clientRepository->findAll(),
        ));
    }

    public function create()
    {
        /**
         * @var Client $client
         */
        $client = $this->clientRepository->create();
        $this->save($client);
        $regions = $this->regionRepository->findAll();
        $this->layout('create', compact('client', 'regions'));
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
        $regions = $this->regionRepository->findAll();
        $this->layout('update', compact('client', 'regions'));
    }

    /**
     * @param $client Client
     * @return void
     */
    protected function save(Client $client)
    {
        if (!empty($this->post)) {
            $client->setAttributes($this->post['Client'] ?? $this->post);
            //if ($client->validate()) {
                if ($client->getDbContext()->commit()) {
                    FlashHelper::set('Сохранено успешно', FlashHelper::TYPE_SUCCESS);
                    $this->redirect("/{$this->id}");
                }
            //}
            $this->message = 'Что то пошло не так';
        }
    }

    public function delete($pk)
    {
        if (!$client = $this->clientRepository->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        echo json_encode(array(
            'success' => $this->clientRepository
                ->findByPk($pk)
                ->delete()
        ));
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
        /** @var \app\models\Invoices */
        $invoicesModel = $this->get('Invoices');
        $debetSum = $invoicesModel->getTotalByContract($where);
        /** @var \app\models\Bills */
        $billsModel = $this->get('Bills');
        $creditSum = $billsModel->getTotalByContract($where);
        $this->layout('reconciliation', array(
            'client' => $client,
            'sender' => $this->get('Settings')->getRequisites('firm'),
            'dateFrom' => $this->dateTime->convDateToReadable($this->get['dateFrom']),
            'dateTo' => $this->dateTime->convDateToReadable($this->get['dateTo']),
            'bills' => $billsModel->getAllByContract($where),
            'invoices' => $invoicesModel->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ));
    }
}