<?php
$this->get('FormBuilder')
    ->build(array(
        'options' => array(
            'action' => $this->getController()->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ),
        'model' => $model,
        'fields' => array('name', 'address', 'region_id' => array(
            'listData' => $this->get('Regions')->getSelectList(),
        ), 'telephone', 'fax', 'contact_fio', 'contact_post', 'account', 'bank', 'INN', 'KPP', 'BIK', 'sort'),
        'fieldValues' => $this->getController()->getQuery('get'),
    ));