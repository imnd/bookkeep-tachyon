<form class="search-form" action="<?=$this->controller->getRoute()?>">
    <?php foreach ($fields as $field) {
        echo $this->display('_search-input', [
            'name' => $field,
            'caption' => $entity->getCaption($field),
        ]);
    }?>
    <input type="submit" class="button" value="поиск">
    <div class="clear"></div>
</form>