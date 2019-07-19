<?=
$this->assetManager->coreJs('ajax'),
$this->assetManager->js('table'),
$this->assetManager->js('prices')
?>
<form method="POST" action="<?=$this->controller->getRoute()?>">
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'number',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'date',
        ])?>
    </div>

    <?php
    $entityName = $entity->getClassName();
    $this->widget([
        'class' => 'tachyon\components\widgets\Datepicker',
        'fieldNames' => ["{$entityName}[date]", "{$entityName}[term_start]", "{$entityName}[term_end]"],
    ])?>

    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'contract_num',
            'class' => 'required',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'client_id',
            'options' => $clients
        ])?>
    </div>
    <?php $this->widget([
        'class' => 'tachyon\components\widgets\Datepicker',
        'controller' => $this->getController(),
        'fieldNames' => array('date'),
    ])?>

    <table class="invoice">
        <tr>
            <th><?=$row->getCaption('articleId')?></th>
            <th>Ед.</th>
            <th><?=$row->getCaption('quantity')?></th>
            <th><?=$row->getCaption('price')?></th>
            <th><?=$row->getCaption('sum')?></th>
        </tr>
        <?php if ($rows = $entity->getRows()) {
            foreach ($entity->getRows() as $row) {
                $this->display('_row', compact('row', 'articlesList'));
            }
        } else {
            $this->display('_row', compact('row', 'articlesList'));
        }?>
        <tr class="total">
            <td colspan="4"><b>Итого:</b></td>
            <td class="total"><?=$entity->getSum()?></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td class="add" id="add"><input type="button"/></td>
        </tr>
    </table>

    <input type="submit" class="button" value="<?=$this->i18n('save')?>">
    <div class="clear"></div>
</form>

<span style="display:none" id="prices"><?=json_encode($articles)?></span>

<script>
    dom.ready(function() {
        prices.setEntityName('<?=$entityName?>');
        prices.calcSums();
        /**
         * при смене номера договора
         * - меняем содержимое поля "клиент";
         * - заполняем массив цен;
         * - меняем цены;
         */
        dom.findByName("contract_num").addEventListener("change", prices.updatePrices);
    });
</script>

<?=$this->assetManager->js("bind-btn-handlers")?>
