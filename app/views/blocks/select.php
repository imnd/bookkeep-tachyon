<?php
$nameClear = str_replace('[]', '', $name);
$value = $entity->getAttribute($nameClear);
if (!isset($label) && isset($entity)) {
    $label = $entity->getCaption($nameClear);
}
if (false!==$label) {?>
    <label><?=$label?>:</label>
<?php }?>
<select
    name="<?=$name?>"
    class="<?=$class ?? ''?>"
    style="<?=$style ?? ''?>"
    <?=isset($readonly) ? 'readonly="readonly"' : ''?>
>
    <?php foreach ($options as $option) {?>
        <option value="<?=$option['value']?>" <?php if ($option['value']==$value) {?>selected="selected"<?php }?>><?=$option['contents']?></option>
    <?php }?>
</select>
