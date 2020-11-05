<script>datepicker.build();</script>
<?php
use tachyon\Request;

$dateFieldNames = array();
// хранить зависимости в assetManager
$this->assetManager->coreJs('obj');
$this->assetManager->coreJs('dom');
$this->assetManager->coreJs('datepicker')
?>
<form class="search-form" action="<?=Request::getRoute()?>">
    <?php foreach ($fields as $key => $field) {?>
        <div class="control">
            <?php
            if (is_numeric($key)) {
                $name = $field['name'] ?? $field;
            } else {
                $name = $key;
            }
            $type = $field['type'] ?? 'input';
            if ($type==='date') {
                $tag = 'input';
                $dateFieldNames[] = $name;
            } else
                $tag = $type;

            $this->display("../blocks/$tag", [
                'entity' => $entity,
                'name' => $name,
                'options' => $field['options'] ?? null,
                'style' => $field['style'] ?? '',
                'value' => Request::getGet($name) ?? '',
            ]);
            ?>
        </div>
    <?php }?>
    <input type="submit" class="button" value="поиск">
    <div class="clear"></div>
</form>
<?php
if (!empty($dateFieldNames)) {
    $this->widget([
        'class' => 'tachyon\components\widgets\Datepicker',
        'controller' => $this->getController(),
        'fieldNames' => $dateFieldNames,
    ]);
}
