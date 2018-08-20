<?php
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'columns' => array('number', 'date', 'sum'),
    'items' => $items,
    // фильтры
    'searchFields' => array(
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'number',
    ),
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => array(
        'delete' => array(
            'type' => 'ajax',
        ),
        'printout',
    ),
));