<?php
if (!isset($label) && isset($entity)) {
    $label = $entity->getCaption($name);
}
if (!isset($value) && isset($entity)) {
    $value = $entity->getAttribute(str_replace('[]', '', $name));
}
if (false!==$label) {?>
    <label><?=$label?>:</label>
<?php }?>

<input
    name="<?=$name?>"
    value="<?=$value ?? ''?>"
    class="<?=$class ?? ''?>"
    style="<?=$style ?? ''?>"
    <?=isset($readonly) ? 'readonly="readonly"' : ''?>
/>
