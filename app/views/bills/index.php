<?php
// таблица
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => [
        'contents' => '$model->getContentsList()[$item["contents"]]',
        'contract_num',
        'clientName',
        'sum',
        'remainder',
        'date'
    ],
    // фильтры
    'searchFields' => [
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'contract_num',
        'client_id' => [
            'listData' => app\models\Clients::getAllSelectList(),
        ],
    ],
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => [
        'delete' => [
            'type' => 'ajax',
        ],
        'update',
    ],
]);