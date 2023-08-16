<?php $datepicker = false;?>
<form class="search-form" action="<?=$this->request->getRoute()?>">
    <?php
    $i = 0;
    foreach ($fields as $key => $field) {?>
        <?php if ($i % 4 === 0) {?>
            <div class="row">
        <?php } ?>
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
            } else {
                $tag = $type;
            }

            $this->display("../blocks/$tag", [
                'entity'  => $entity,
                'name'    => $name,
                'options' => $field['options'] ?? null,
                'style'   => $field['style'] ?? null,
                'class'   => $field['class'] ?? null,
                'value'   => $this->request->getGet($name) ?? '',
            ]);
            ?>
        </div>
        <?php if ($i++ % 4 === 3) {?>
            </div><div class="clear"></div>
        <?php }?>
    <?php }?>
    <?php if ($i++ % 4 !== 0) {?></div><?php }?>
    <div class="clear"></div>
    <div class="row">
        <input type="submit" class="button" value="поиск" />
    </div>
    <div class="clear"></div>
</form>
<?php if ($datepicker) {?>
    <script type="module" src="/assets/js/datepicker.mjs"></script>
<?php }?>
