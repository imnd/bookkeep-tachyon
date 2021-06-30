<?php
use tachyon\Request;

/** @var app\entities\Contract $entity */
/** @var array $types */
?>

<form method="POST" action="<?=Request::getRoute()?>">
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'type',
            'options' => $types
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

    <input type="submit" class="button" value="<?=$this->i18n('save')?>">
    <div class="clear"></div>
</form>

<span style="display: none" id="prices"><?=json_encode($articles)?></span>

<script type="module">
    import datepicker from '/assets/js/datepicker.js';
    datepicker.build();

    import dom from '/assets/js/dom.js';
    import prices from '/assets/js/prices.js';
    dom.ready(function() {
        prices.setEntityName('<?=$entity->getClassName()?>');
        prices.calcSums();
        dom.findByName("contract_num").addEventListener("change", prices.updatePrices);
    });
</script>

<script type="module" src="/assets/js/bind-btn-handlers.js"></script>
