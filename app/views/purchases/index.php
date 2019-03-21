<?php
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'columns' => array('number', 'date', 'sum'),
    'items' => $items,
    // фильтры
    'searchFields' => [
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'number',
    ],
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => [
        'delete' => [
            'type' => 'ajax',
        ],
        'printout',
    ],
]);