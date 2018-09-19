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
        'activeText' => '$model->get("activeBehaviour")->getActiveText($model, $item)'
    ),
    // фильтры
    'searchFields' => array(
        'subcat_id' => array(
            'listData' => app\models\ArticleSubcats::getSelectList(),
        ),
        'name',
        'unit' => array(
            'listData' => $model->get('listBehaviour')->getSelectListFromArr($model->getUnits()),
        ),
        'priceFrom',
        'priceTo',
        'active' => array(
            'listData' => $model->get('listBehaviour')->getYesNoListData(),
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
