<form method="POST" action="<?=$this->request->getRoute()?>">
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'subcat_id',
            'options' => $articleSubcats
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/select', [
            'entity' => $entity,
            'name' => 'unit',
            'options' => $units
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'name',
        ])?>
    </div>
    <div class="row">
        <?php $this->display('../blocks/input', [
            'entity' => $entity,
            'name' => 'price',
        ])?>
    </div>
    <input type="submit" class="button" value="<?=t('save')?>">
    <div class="clear"></div>
</form>
