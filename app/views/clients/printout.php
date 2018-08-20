<?php $this->pageTitle = "Печать акта сверки клиента {$client->name}"?>
<h3>Акт сверки</h3>
<?=$this->html->formOpen()?>
    <div class="row">
        <?=
        $this->html->label('с'),
        $this->html->input('dateFrom')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->label('по'),
        $this->html->input('dateTo')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->label('контракт №'),
        $this->html->input('contract_num')
        ?>
    </div>
    <?php
    $this->widget(array(
        'class' => 'Datepicker',
        'fieldNames' => array('dateFrom', 'dateTo'),
    ));

    echo $this->html->submit($this->i18n('print'));

echo $this->html->formClose();
