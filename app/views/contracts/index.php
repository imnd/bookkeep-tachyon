<?php
if (!is_null($type)) {
    $this->setProperty('bodyClass', $this->getProperty('bodyClass') . " $type");
} else {
    $this->setProperty('bodyClass', 'contracts_and_agreements');
}
$this->pageTitle = "Список {$model->getTypeName($type, 'gen')}";
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => [
        'contract_num', 'date', 'term_start', 'term_end',
        'clientName' => '"{$item["clientName"]} ({$item["clientAddr"]})"',
        'sum', 'executed', 'execRemind', 'payed', 'payedRemind'
    ],
    // фильтры
    'searchFields' => [
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'client_id' => [
            'listData' => app\models\Clients::getAllSelectList(),
        ],
        'contract_num',
   ],
    // поля по которым выводится сумма внизу таблицы
    'sumFields' => array('sum', 'executed', 'execRemind', 'payed', 'payedRemind'),
    // кнопки
    'buttons' => [
        'delete',
        'update',
        'printout',
    ],
]);
