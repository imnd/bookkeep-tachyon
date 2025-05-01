<?php
$this->pageTitle .= ', редактирование реквизитов' ?>
<?= $this->html->formOpen(['method' => 'POST']) ?>
<h3>Хозяин</h3>
<?php
$this->display(
    '_requisites',
    [
        'requisites' => $requisitesAll,
        'type' => 'firm',
    ]
) ?>
<h3>Поставщик</h3>
<?php
$this->display(
    '_requisites',
    [
        'requisites' => $requisitesAll,
        'type' => 'supplier',
    ]
);
echo
$this->html->submit(t('save')),
$this->html->formClose();
