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
            'contract_num',
            'client_id' => [
                'listData' => app\models\Clients::getSelectList(),
            ],
            'date' => array('type' => 'date'),
            'sum',
            'remainder',
            'contents' => [
                'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getContentsList(), true, false)
            ],
        ],
        'fieldValues' => $this->controller->getGet(),
    ]);
