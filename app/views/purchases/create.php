<?=
$this->assetManager->coreJs('ajax'),
$this->assetManager->js('prices'),

$this->html->formOpen(),

    'за: ', $this->html->input([
        'name' => 'date',
        'value' => $date
    ]),
    $this->widget([
        'class' => 'tachyon\components\widgets\Datepicker',
        'fieldNames' => array('date'),
        'return' => true,
    ]),
    '&nbsp;',
    $this->html->submit('Собрать'),

$this->html->formClose();

$this->pageTitle = 'Собираем закупку';
if (!empty($items)) {?>
    <hr />
    <script><!--
        dom.ready(function() {
            bindInpsChange('quantity');
            bindInpsChange('price');
            bindInpsChange('sum');
        });
    //--></script>
    <?=$this->html->formOpen(array('method' => 'POST'))?>
    <p>Номер фактуры закупки: <?=$this->html->inputEx($model, 'number')?>&nbsp;<?=$this->html->error($model, 'number')?></p>
    <table class="purchase">
        <tr>
            <th>Товар</th>
            <th>Кол-во</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        <?php foreach ($items as $i => $item) {?>
            <tr class="row">
                <?=$this->html->hiddenEx($rowModel, [
                    'name' => 'article_subcategory_id',
                    'value' => $item['article_subcat_id'],
                    'multiple' => true,
                ])?>
                <td><?=$item['article_subcat']?></td>
                <td class="quantity"><?=$this->html->hiddenEx($rowModel, [
                    'name' => 'quantity',
                    'value' => $item['quantity'],
                    'multiple' => true,
                ]), $item['quantity']?></td>
                <td class="price"><?=$this->html->inputEx($rowModel, [
                    'name' => 'price',
                    'multiple' => true,
                ])?></td>
                <td class="sum"><?=$this->html->input([
                    'name' => 'sum',
                    'readonly' => 'readonly',
                ])?></td>
            </tr>
        <?php }?>
        <tr class="total">
            <td colspan="3"><b>Итого:</b></td>
            <td class="total">0</td>
        </tr>
    </table>
    <?php
    echo
        $this->html->submit('Сохранить'),
        $this->html->formClose();
} else {?>
    <p>список пуст.</p>
<?php }
