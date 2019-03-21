<?php
// таблица
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => ['name', 'address', 'telephone', 'fax', 'contact_fio', 'contact_post', 'account', 'bank', 'INN', 'KPP', 'BIK'],
    // фильтры
    'searchFields' => [
        'name',
        'address',
    ],
    // кнопки
    'buttons' => [
        'deactivate' => [
            'type' => 'ajax',
        ],
        'update',
        'printout',
    ],
]);