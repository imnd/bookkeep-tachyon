<script type="text/javascript" src="/assets/js/table.js"></script>
<script type="text/javascript" src="/assets/js/prices.js"></script>
<?php
use tachyon\dic\Container;

$modelName = $model->getClassName();
echo $this->html->formOpen(array('method' => 'POST'));
?>
    <div class="row">
        <?php /*
        <?=
        $this->html->labelEx($model, 'type'),
        $this->html->selectEx($model, array(
            'name' => 'type',
            'options' => Container::getInstanceOf('Contracts')->getTypes()
        ))
        ?>
        */?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'contract_num'),
        $this->html->inputEx($model, 'contract_num')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'date'),
        $this->html->inputEx($model, 'date')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'term_start'),
        $this->html->inputEx($model, 'term_start')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'term_end'),
        $this->html->inputEx($model, 'term_end')
        ?>
    </div>
    <?php $this->widget(array(
        'class' => 'Datepicker',
        'fieldNames' => array("{$modelName}[date]", "{$modelName}[term_start]", "{$modelName}[term_end]"),
    ))?>

    <div class="row">
        <?=
        $this->html->labelEx($model, 'client_id'),
        $this->html->selectEx($model, array(
            'name' => 'client_id',
            'options' => app\models\Clients::getSelectList()
        ))
        ?>
    </div>

    <?php /*
    <div class="row">
        <?php
        echo $this->html->labelEx($model, 'payed');
        echo $this->html->inputEx($model, 'payed');
        ?>
    </div>
    */?>

    <table>
        <tr>
            <th>Наименование товара</th>
            <th>Ед.</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        <?php
        $articles = app\models\Articles::getSelectList();
        if ($model->isNew) {
            $this->display('_row', array(
                'row' => Container::getInstanceOf('ContractsRows'),
                'articles' => $articles
            ));
        } else
            foreach ($model->rows as $row)
                $this->display('_row', compact('row', 'articles'));
        ?>
        <tr class="total">
            <td colspan="4"><b>Итого:</b></td>
            <td class="total"><?=$model->sum?></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td class="add" id="add"><?=$this->html->button()?></td>
        </tr>
    </table>
    <?=$this->html->submit($this->i18n('save'))?>
<?=$this->html->formClose() ?>
<span style="display: none" id="prices"><?=json_encode(Container::getInstanceOf('Articles')->getAll())?></span>
<script>
    dom.ready(function() {
        prices.setModelName('<?=$modelName?>');
    });
</script>
<script type="text/javascript" src="/assets/js/bindBtnHandlers.js"></script>
