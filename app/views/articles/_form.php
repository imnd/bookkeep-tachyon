<?php
$this->get('FormBuilder')
    ->build([
        'options' => [
            'action' => $this->controller->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ],
        'model' => $model,
        'fields' => [
            'subcat_id' => [
                'listData' => app\models\ArticleSubcats::getSelectList()
            ],
            'unit' => [
                'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getUnits())
            ],
            'name',
            'price',
        ],
        'fieldValues' => $this->controller->getGet(),
    ]);
