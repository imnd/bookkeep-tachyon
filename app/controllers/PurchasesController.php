<?php
namespace app\controllers;

use tachyon\helpers\DateTimeHelper,
    app\models\Settings;

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
        $container = new \tachyon\dic\Container;
        $model = $container->get($this->modelName);
        $rowModel = $container->get($model->getRowModelName());
        if (!empty($this->get['date'])) {
            $date = $this->get['date'];
            $items = $model->getReport($date);
        } else {
            // Текущая дата в стандартном формате
            $date = date('Y-m-d');
            $items = array();
        }
        $model->date = $date;
        if (!empty($this->post)) {
            $model->setAttributes($this->post[$this->modelName]);
            if ($model->save())
                $this->redirect("/{$this->id}");
        }
        $this->layout('create', compact('model', 'rowModel', 'date', 'items'));
    }

    /**
     * @param Settings $settings
     * @param int $pk
     */
    public function printout(Settings $settings, $pk)
    {
        $this->layout = 'printout';

        $item = $this->model
            ->with('rows')
            ->findByPk($pk);

        $this->display('printout', array(
            'item' => $item,
            'contractType' => 'Договор',
            'quantitySum' => $this->model->getQuantitySum($pk),
            'sender' => $settings->getRequisites('supplier'),
            'client' => (object)$settings->getRequisites('firm'),
        ));
    }
}
