<?php
/** @var app\entities\Contract $entity */
/** @var array $clients */

use tachyon\Request;

echo
    $this->assetManager->js('table'),
    $this->assetManager->js('prices');

$this->assetManager->coreJs('ajax');
// хранить зависимости в assetManager
$this->assetManager->coreJs('obj');
$this->assetManager->coreJs('dom');
$this->assetManager->coreJs('datepicker')
?>
<script>datepicker.build();</script>

<form method="POST" action="<?=Request::getRoute()?>">
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
            'class' => 'datepicker',
        ])?>
    </div>

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

    <table class="invoice">
        <tr>
            <th><?=$row->getCaption('articleId')?></th>
            <th>Ед.</th>
            <th><?=$row->getCaption('quantity')?></th>
            <th><?=$row->getCaption('price')?></th>
            <th><?=$row->getCaption('sum')?></th>
        </tr>
        <?php
        if (!$rows = $entity->getRows()) {
            $rows = [$row];
        }
        foreach ($rows as $row) {
            $this->display('_row', compact('row', 'articlesList'));
        }
        ?>
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
        prices.setEntityName('<?=$entity->getClassName()?>');
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
