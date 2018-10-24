<?=$this->assetManager->coreJs("ajax")?>
<script type="text/javascript" src="/assets/js/table.js"></script>
<script type="text/javascript" src="/assets/js/prices.js"></script>

<?=$this->html->formOpen(array('method' => 'POST'))?>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'number'),
        $this->html->inputEx($model, 'number')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'date'),
        $this->html->inputEx($model, 'date')
        ?>
        <?php
        $modelName = $model->getClassName();
        $this->widget(array(
            'class' => 'Datepicker',
            'fieldNames' => array("{$modelName}[date]"),
        ));
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'contract_num'),
        $this->html->inputEx($model, 'contract_num')
        ?>
    </div>
    <div class="row">
        <?=
        $this->html->labelEx($model, 'client_id'),
        $this->html->selectEx($model, array(
            'name' => 'client_id',
            'options' => app\models\Clients::getSelectList()
        ))
        ?>
    </div>
    <table class="invoice">
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
                'row' => $this->get('InvoicesRows'),
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
            <td class="add" id="add"><?=$this->html->button(); ?></td>
        </tr>
    </table>
    <?=$this->html->submit($this->i18n('save')); ?>
<?=$this->html->formClose() ?>
<span style="display: none" id="prices"><?=json_encode($this->get('Articles')->getAll())?></span>

<script>
    dom.ready(function() {
        prices.setModelName('<?=$modelName?>');
        /**
         * при смене номера договора
         * - меняем содержимое поля "клиент";
         * - заполняем массив цен;
         * - меняем цены;
         */
        dom.findByName(prices.modelName + "[contract_num]").addEventListener("change", prices.updatePrices);
    });
</script>
<script type="text/javascript" src="/assets/js/bind-btn-handlers.js"></script>

