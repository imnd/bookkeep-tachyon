<?php
use tachyon\dic\Container;

(new Container)->get('\tachyon\components\html\FormBuilder')
    ->build(array(
        'options' => array(
            'submitCaption' => $this->i18n('save'),
            'method' => 'POST',
        ),
        'model' => $model,
        'fields' => $model->getFields(),
        'fieldValues' => $this->controller->getGet(),
    ));