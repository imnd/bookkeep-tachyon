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
     * @var app\models\Settings
     */
    protected $settings;

    public function __construct(Settings $settings, ...$params)
    {
        $this->settings = $settings;

        parent::__construct(...$params);
    }

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

    public function printout($pk)
    {
        $this->layout = 'printout';

        $item = $this->model
            ->with('rows')
            ->findByPk($pk);

        $this->display('printout', array(
            'item' => $item,
            'contractType' => 'Договор',
            'quantitySum' => $this->model->getQuantitySum($pk),
            'sender' => $this->settings->getRequisites('supplier'),
            'client' => (object)$this->settings->getRequisites('firm'),
        ));
    }
}
