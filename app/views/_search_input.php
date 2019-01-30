<div class="control">
    <label><?=$entity->getCaption($name)?>:</label>
    <input style="width: 300px" name="<?=$name?>" value="<?=$this->controller->getGet($name)?>">
</div>