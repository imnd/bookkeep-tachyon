<?php
$this->get('FormBuilder')
    ->build(array(
        'options' => array(
            'action' => $this->getController()->getRoute(),
            'method' => 'POST',
            'submitCaption' => $this->i18n('save'),
        ),
        'model' => $model,
        'fields' => array(
            'subcat_id' => array(
                'listData' => app\models\ArticleSubcats::getSelectList()
            ),
            'unit' => array(
                'listData' => $model->getListBehaviour()->getSelectListFromArr($model->getUnits())
            ),
            'name',
            'price',
        ),
        'fieldValues' => $this->getController()->getQuery('get'),
    ));
