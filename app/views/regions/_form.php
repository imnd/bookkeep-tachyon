<?php
$this->get('FormBuilder')
    ->build(array(
        'options' => array(
            'submitCaption' => $this->i18n('save'),
            'method' => 'POST',
        ),
        'model' => $model,
        'fields' => $model::$fields,
        'fieldValues' => $this->getController()->getGet(),
    ));