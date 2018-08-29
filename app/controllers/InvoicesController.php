<?php
namespace app\controllers;

/**
 * Контроллер фактур
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class InvoicesController extends \app\components\CrudController
{
    public function printout($pk)
    {
        $type = $this->get['type'];
        $item = $this->model
            ->with('rows')
            ->with('client')
            ->with('contract')
            ->findByPk($pk);

        $client = $item->client;
        $contractType = $item->getContractType();
        $contractNum = $item->contract_num;
        $quantitySum = $this->model->getQuantitySum($pk);
        $sender = $this->get('Settings')->getRequisites('firm');
        $this->layout("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
