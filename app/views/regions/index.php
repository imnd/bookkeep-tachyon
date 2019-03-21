<?php
$this->pageTitle = 'Список районов';
// таблица
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => ['name'],
    // фильтры
    'searchFields' => ['name'],
    // кнопки
    'buttons' => [
        'delete',
        'update',
    ],
]);