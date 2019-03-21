<?php
namespace app\controllers;

use app\models\Settings;

/**
 * Контроллер фактур
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class InvoicesController extends \app\components\CrudController
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
     * @inheritdoc 
     */
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
        $sender = $this->settings->getRequisites('firm');
        $this->layout("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
