<?php $this->pageTitle .= ', редактирование реквизитов'?>
<?=$this->html->formOpen(array('method' => 'POST'))?>

<h3>Хозяин</h3>
<?php $this->display('_requisites', array(
    'requisites' => $requisitesAll,
    'type' => 'firm',
))?>

<h3>Поставщик</h3>
<?php
$this->display('_requisites', array(
    'requisites' => $requisitesAll,
    'type' => 'supplier',
))?>
<?=
$this->html->submit($this->i18n('save')),
$this->html->formClose();
