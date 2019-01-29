<?php
$this->setLayout('update');
$this->setPageTitle('Клиент, редактирование');

$this->display('_form', compact('client', 'regions'));
