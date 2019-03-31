<?php $dateFieldNames = array()?>
<form class="search-form" action="<?=$this->controller->getRoute()?>">
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
                'value' => $this->controller->getGet($name) ?? '',
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
