<?php
$this->pageTitle = 'Список районов';
// таблица
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array('name'),
    // фильтры
    'searchFields' => array('name'),
    // кнопки
    'buttons' => array(
        'delete',
        'update',
    ),
));