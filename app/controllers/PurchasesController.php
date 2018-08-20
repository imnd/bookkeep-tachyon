<?php
namespace app\controllers;

use tachyon\helpers\DateTimeHelper;
use tachyon\dic\Container;

/**
 * class Purchases
 * Контроллер закупок
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class PurchasesController extends \app\components\CrudController
{
    /**
     * Собираем закупку за определенное число
     */
    public function create()
    {
        $modelName = \tachyon\helpers\StringHelper::getShortClassName($this->modelName);
        $model = Container::getInstanceOf($modelName);
        $rowModel = Container::getInstanceOf($model->getRowModelName());
        if (!empty($this->get['date'])) {
            $date = $this->get['date'];
            $items = $model->getReport($date);
        } else {
            $date = DateTimeHelper::getCurDate();
            $items = array();
        }
        $model->date = $date;
        if (!empty($this->post)) {
            $model->setAttributes($this->post[$modelName]);
            if ($model->save())
                $this->redirect("/{$this->id}");
        }
        $this->layout('create', compact('model', 'rowModel', 'date', 'items'));
    }

    public function printout($pk)
    {
        $item = $this->model
            ->with('rows')
            ->findByPk($pk);

        $this->display('printout', array(
            'item' => $item,
            'contractType' => 'Договор',
            'quantitySum' => $this->model->getQuantitySum($pk),
            'sender' => Container::getInstanceOf('Settings')->getRequisites('supplier'),
            'client' => (object)Container::getInstanceOf('Settings')->getRequisites('firm'),
        ));
    }
}
