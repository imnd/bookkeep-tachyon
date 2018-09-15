<?php
namespace app\controllers;

use tachyon\dic\Container;

/**
 * Контроллер клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ClientsController extends \app\components\CrudController
{
    use \tachyon\dic\behaviours\DateTime;

    public function init()
    {
        parent::init();

        $this->mainMenu['/regions'] = 'районы';
    }

    public function printout($pk)
    {
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
            'dateFrom' => $this->getDateTimeBehaviour()->convDateToReadable($this->get['dateFrom']),
            'dateTo' => $this->getDateTimeBehaviour()->convDateToReadable($this->get['dateTo']),
            'bills' => $billsModel->getAllByContract($where),
            'invoices' => $invoicesModel->getAllByContract($where),
            'debetSum' => number_format($debetSum, 2, '.', ''),
            'creditSum' => number_format($creditSum, 2, '.', ''),
            'saldo' => number_format($debetSum - $creditSum, 2, '.', ''),
            'saldoStart' => 0
        ));
    }
}