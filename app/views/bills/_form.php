<?php
use tachyon\dic\Container,
    tachyon\Request,
    app\models\Clients;

(new Container)->get('\tachyon\components\html\FormBuilder')
    ->build([
        'options' => [
            'action' => Request::getRoute(),
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
                'listData' => $model->getSelectListFromArr($model->getContentsReadable(), true, false)
            ],
        ],
        'fieldValues' => Request::getGet(),
    ]);
