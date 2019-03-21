<?php
use tachyon\dic\Container,
    app\models\Clients;

(new Container)->get('\tachyon\components\html\FormBuilder')
    ->build([
        'options' => [
            'action' => $this->controller->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ],
        'model' => $model,
        'fields' => [
            'contract_num',
            'client_id' => [
                'listData' => Clients::getAllSelectList(),
            ],
            'date' => array('type' => 'date'),
            'sum',
            'remainder',
            'contents' => [
                'listData' => $model->getSelectListFromArr($model->getContentsList(), true, false)
            ],
        ],
        'fieldValues' => $this->controller->getGet(),
    ]);
