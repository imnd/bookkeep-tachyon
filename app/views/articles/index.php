<?php
$this->pageTitle = 'Список товаров';
// таблица
$this->widget([
    'class' => 'tachyon\components\widgets\grid\Grid',
    'model' => $model,
    'items' => $items,
    'columns' => [
        'subcatName',
        'name',
        'unit',
        'price',
        'activeText' => '$model->getActiveBehaviour()->getActiveText($model, $item)'
    ],
    // фильтры
    'searchFields' => [
        'subcat_id' => [
            'listData' => app\models\ArticleSubcats::getAllSelectList(),
        ],
        'name',
        'unit' => [
            'listData' => $model->getSelectListFromArr($model->getUnits()),
        ],
        'priceFrom',
        'priceTo',
        'active' => [
            'listData' => $model->getYesNoListData(),
        ],
    ],
    // кнопки
    'buttons' => [
        'deactivate' => [
            'type' => 'ajax',
        ],
        'update',
    ],
]);
