<?php
$this->pageTitle = 'Список товаров';
// таблица
$this->widget(array(
    'class' => 'Grid',
    'model' => $model,
    'items' => $items,
    'columns' => array(
        'subcatName',
        'name',
        'unit',
        'price',
        'activeText' => '$model->getActiveBehaviour()->getActiveText($model, $item)'
    ),
    // фильтры
    'searchFields' => array(
        'subcat_id' => array(
            'listData' => app\models\ArticleSubcats::getSelectList(),
        ),
        'name',
        'unit' => array(
            'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getUnits()),
        ),
        'priceFrom',
        'priceTo',
        'active' => array(
            'listData' => $model->getListBehaviour()->getYesNoListData(),
        ),
    ),
    // кнопки
    'buttons' => array(
        'deactivate' => array(
            'type' => 'ajax',
        ),
        'update',
    ),
));
