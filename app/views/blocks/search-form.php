<?php
use tachyon\Request;

$datepicker = false;
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
                $datepicker = true;
                $tag = 'input';
                $field['class'] = $field['class'] ?? '';
                $field['class'] .= ' datepicker';
            } else
                $tag = $type;

            $this->display("../blocks/$tag", [
                'entity'  => $entity,
                'name'    => $name,
                'options' => $field['options'] ?? null,
                'style'   => $field['style'] ?? null,
                'class'   => $field['class'] ?? null,
                'value'   => Request::getGet($name) ?? '',
            ]);
            ?>
        </div>
    <?php }?>
    <input type="submit" class="button" value="поиск">
    <div class="clear"></div>
</form>
<?php if ($datepicker) {
    // хранить зависимости в assetManager
    $this->assetManager->coreJs('obj');
    $this->assetManager->coreJs('dom');
    $this->assetManager->coreJs('datepicker');
    ?>
    <script>datepicker.build();</script>
<?php }?>
