<?php
/** @var \tachyon\View $this */
$this->setLayout('form');
$this->setPageTitle('Клиент, создание');
$this->display('_form', compact('entity', 'regions'));
