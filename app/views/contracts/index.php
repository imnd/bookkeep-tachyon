<?php
if (!is_null($type))
    $this->setProperty('bodyClass', $this->getProperty('bodyClass') . " $type");
else
    $this->setProperty('bodyClass', 'contracts_and_agreements');

$this->pageTitle = "Список {$model->getTypeName($type, 'gen')}";
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('contract_num', 'date', 'term_start', 'term_end',
    'clientName' => '"{$item["clientName"]} ({$item["clientAddr"]})"',
    'sum', 'executed', 'execRemind', 'payed', 'payedRemind'),
    // фильтры
    'searchFields' => array(
        'dateFrom' => array('type' => 'date'),
        'dateTo' => array('type' => 'date'),
        'client_id' => array(
            'listData' => app\models\Clients::getSelectList(),
        ),
        'contract_num',
    ),
    // поля по которым выводится сумма внизу таблицы
    'sumFields' => array('sum', 'executed', 'execRemind', 'payed', 'payedRemind'),
    // кнопки
    'buttons' => array(
        'delete',
        'update',
        'printout',
    ),
));
