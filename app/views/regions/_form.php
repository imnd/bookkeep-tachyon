<?php
tachyon\dic\Container::getInstanceOf('FormBuilder')
    ->build(array(
        'options' => array(
            'submitCaption' => $this->i18n('save'),
            'method' => 'POST',
        ),
        'model' => $model,
        'fields' => $model::$fields,
        'fieldValues' => $this->getController()->getQuery('get'),
    ));