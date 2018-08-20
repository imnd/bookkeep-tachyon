<?php
// таблица
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('contents' => '$model->getContentsList()[$item["contents"]]', 'contract_num', 'clientName', 'sum', 'remainder', 'date'),
    // фильтры
    'searchFields' => array(
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'contract_num',
        'client_id' => array(
            'listData' => app\models\Clients::getSelectList(),
        ),
        /*'contents' => array(
            'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getContentsList(), true)
        ),*/
    ),
    'sumFields' => array('sum'),
    // кнопки
    'buttons' => array(
        'delete' => array(
            'type' => 'ajax',
        ),
        'update',
    ),
));