<?php
$model->number = $model->getLastNumber() + 1;
$this->display('_form', compact('model'));