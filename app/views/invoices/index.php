<?php
/**
 * @var \tachyon\View $this
 */

$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('number', 'date', 'clientName', 'contract_num', 'sum'),
    // фильтры
    'searchFields' => array(
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'number',
        'contract_num',
        'client_id' => array(
            'listData' => app\models\Clients::getSelectList(),
        ),
    ),
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => array(
        'view',
        'delete' => array(
            'type' => 'ajax',
        ),
        'update',
        array(
            'action' => 'printout',
            'title' => 'распечатать фактуру',
            'vars' => array('type' => 'bill')
        ),
        array(
            'action' => 'printout',
            'title' => 'распечатать накладную',
            'vars' => array('type' => 'invoice')
        ),
    ),
));
