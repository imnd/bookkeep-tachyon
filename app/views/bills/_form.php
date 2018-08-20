<?php
tachyon\dic\Container::getInstanceOf('FormBuilder')
    ->build(array(
        'options' => array(
            'action' => $this->getController()->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ),
        'model' => $model,
        'fields' => array(
            'contract_num',
            'client_id' => array(
                'listData' => app\models\Clients::getSelectList(),
            ),
            'date' => array('type' => 'date'),
            'sum',
            'remainder',
            'contents' => array(
                'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getContentsList(), true, false)
            ),
        ),
        'fieldValues' => $this->getController()->getQuery('get'),
    ));
