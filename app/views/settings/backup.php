<?php $this->pageTitle = ''?>

<h1><?=$this->pageTitle?></h1>

<form method="POST" action="/settings/backup">

<?=form_open("", array('style'=>"float:left;margin-right:10px;padding-right:10px;border-right: 1px solid #999;"))?>
    <input type="submit" value="создать резервную копию" />
</form>

<form enctype="multipart/form-data" method="POST" action="/settings/restore">
    <input type="file" name="backup" />
    <input class="submit orange_back" type="submit" value="восстановить из резервной копии" />
</form>
<hr />
<p><b>Пути для сохранения резервной копии:</b></p>
<form method="post" id="setPaths" action="/admin/SetBackupPaths">
    <?php if (empty($paths)) {?>
    <input value="" name="path0" class="path" id="0" />
    <?php } else {?>
        <?php foreach ($paths as $path) {
            $fieldName = $path->key;?>
            <input value="<?=$path->value?>" name="<?=$fieldName?>" class="path"  id="<?=substr($fieldName, -1)?>" />
        <?php }?>
    <?php }?>
    <input class="button" type="button" name="add" value="добавить" />
    <br />
    <br />
    <input class="submit orange_back" type="submit" value="установить" />
</form>
<script language="JavaScript">
<!--
dom.ready(function() {
    // добавление поля
    dom.findByName("add").addEventListener("click", () => {
        let pathElt = dom.findByName("path"),
            inpClone = pathElt.last().clone(),
            nextNumb = parseInt(inpClone.attr('id')) + 1;
        inpClone.attr('name', inpClone.attr('class') + nextNumb);
        inpClone.attr('id', nextNumb);
        inpClone.attr('value', '');
        pathElt.last().after(inpClone);
    });
})();
//-->
</script>
