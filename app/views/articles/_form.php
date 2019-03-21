<?php
use tachyon\dic\Container,
    app\models\ArticleSubcats;


(new Container)->get('\tachyon\components\html\FormBuilder')
    ->build([
        'options' => [
            'action' => $this->controller->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ],
        'model' => $model,
        'fields' => [
            'subcat_id' => [
                'listData' => ArticleSubcats::getAllSelectList()
            ],
            'unit' => [
                'listData' => $model->getSelectListFromArr($model->getUnits())
            ],
            'name',
            'price',
        ],
        'fieldValues' => $this->controller->getGet(),
    ]);
