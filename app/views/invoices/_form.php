<?php
/** @var app\entities\Contract $entity */
/** @var array $clients */
/** @var \tachyon\Model $row */

use tachyon\helpers\ClassHelper;
?>

<script type="module" src="/assets/js/datepicker.mjs"></script>

<form method="POST" action="<?=request()->getRoute()?>">
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

    <input type="submit" class="button" value="<?=t('save')?>">
    <div class="clear"></div>
</form>

<span style="display:none" id="prices"><?=json_encode($articles)?></span>

<script type="module">
  import setup from '/assets/js/invoices-form.mjs';
  setup('<?=ClassHelper::getClassName($entity)?>');
</script>
<script type="module" src="/assets/js/bind-btn-handlers.mjs"></script>
