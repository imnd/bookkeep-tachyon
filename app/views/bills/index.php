<?php
// таблица
$this->widget([
    'class' => 'Grid',
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
            'listData' => app\models\Clients::getSelectList(),
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
));