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
        $this->layout = 'printout';

        $type = $this->get['type'];
        if (!$item = $this->model
            ->with('rows')
            ->with('client')
            ->with('contract')
            ->findByPk($pk)
        ) {
            $this->error(404, 'Такой фактуры не существует');
        }
        $client = $item->client;
        $contractType = $item->getContractType();
        $contractNum = $item->contract_num;
        $quantitySum = $this->model->getQuantitySum($pk);
        $sender = $this->get('Settings')->getRequisites('firm');
        $this->layout("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
