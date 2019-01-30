<?php
// таблица
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('name', 'address', 'telephone', 'fax', 'contact_fio', 'contact_post', 'account', 'bank', 'INN', 'KPP', 'BIK'),
    // фильтры
    'searchFields' => array(
        'name',
        'address',
    ),
    // кнопки
    'buttons' => array(
        'deactivate' => array(
            'type' => 'ajax',
        ),
        'update',
        'printout',
    ),
));