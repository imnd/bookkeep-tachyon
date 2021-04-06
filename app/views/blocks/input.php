<?php
if (!isset($label) && isset($entity)) {
    $label = $entity->getCaption($name);
}
if (!isset($value) && isset($entity)) {
    $value = $entity->getAttribute(str_replace('[]', '', $name));
    /*$arr = array_map(
        static fn($elem) => ucfirst($elem),
        explode('_', str_replace('[]', '', $name))
    );
    $method = 'get' . implode('', $arr);
    if (method_exists($entity, $method)) {
        $value = $entity->$method();
    }*/
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
