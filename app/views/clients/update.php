@extends('form')

<?php
$this->setPageTitle('Клиент, редактирование');
$this->display('_form', compact('entity', 'regions'));
