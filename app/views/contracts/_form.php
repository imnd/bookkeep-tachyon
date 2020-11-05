<?php
use tachyon\Request;

/** @var app\entities\Contract $entity */

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
    <?php /*
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'type',
            'options' => $entityRepo->getTypes()
        ])?>
    </div>
    */?>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'contractNum',
            'class' => 'required',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'date',
            'class' => 'required datepicker',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'termStart',
            'class' => 'datepicker',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'termEnd',
            'class' => 'datepicker',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'client_id',
            'options' => $clients
        ])?>
    </div>
    <?php /*
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'payed',
        ])?>
    </div>
    */?>

    <table>
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

    <?php
    $entityName = $entity->getClassName();
    $this->widget([
        'class' => 'tachyon\components\widgets\Datepicker',
        'fieldNames' => ["{$entityName}[date]", "{$entityName}[term_start]", "{$entityName}[term_end]"],
    ])?>

    <input type="submit" class="button" value="<?=$this->i18n('save')?>">
    <div class="clear"></div>
</form>

<span style="display: none" id="prices"><?=json_encode($articles)?></span>

<script>
    dom.ready(function() {
        prices.setEntityName('<?=$entityName?>');
        prices.calcSums();
        dom.findByName("contractNum").addEventListener("change", prices.updatePrices);
    });
</script>

<?=$this->assetManager->js("bind-btn-handlers")?>
