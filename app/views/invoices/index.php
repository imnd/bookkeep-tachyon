<?php
/**
 * @var \tachyon\View $this
 */

$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('number', 'date', 'client_name', 'contract_num', 'sum'),
    // фильтры
    'searchFields' => [
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'number',
        'contract_num',
        'client_id' => [
            'listData' => app\models\Clients::getAllSelectList(),
        ],
    ],
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => [
        'view',
        'delete' => [
            'type' => 'ajax',
        ],
        'update',
        [
            'action' => 'printout',
            'title' => 'распечатать фактуру',
            'vars' => array('type' => 'bill')
        ],
        [
            'action' => 'printout',
            'title' => 'распечатать накладную',
            'vars' => array('type' => 'invoice')
        ],
    ],
]);
