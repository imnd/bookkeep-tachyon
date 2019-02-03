<h1><?=$head?></h1>

<?=form_open("/admin/MakeBackup/false", array('style'=>"float:left;margin-right:10px;padding-right:10px;border-right: 1px solid #999;"))?>
    <input class="submit orange_back" type="submit" value="создать резервную копию" />
<?=form_close()?>
<?=form_open_multipart("/admin/RestoreFromBackup/")?>
    <input class="submit orange_back" type="submit" value="восстановить из резервной копии" />
    <?=form_upload("backup_path") ?>
<?=form_close()?>
<hr />
<p><b>Пути для сохранения резервной копии:</b></p>
<form method="post" id="setPaths" action="/admin/SetBackupPaths">
    <?php if (empty($paths)):?>
    <input value="" name="path0" class="path" id="0" />
    <?php else :?>
        <?php foreach ($paths as $path):
            $fieldName = $path->key;?>
            <input value="<?=$path->value?>" name="<?=$fieldName?>" class="path"  id="<?=substr($fieldName, -1)?>" />
        <?php endforeach?>
    <?php endif?>
    <input class="button" type="button" name="add" value="добавить" />    
    <br />
    <br />
    <input class="submit orange_back" type="submit" value="установить" />    
</form>
<script language="JavaScript">
<!--
(function() {
    // добавление поля
    $('input[name="add"]').click(function() {
        var inpClone = $('input[name*="path"]').last().clone();
        var nextNumb = parseInt(inpClone.attr('id')) + 1;
        inpClone.attr('name', inpClone.attr('class') + nextNumb);
        inpClone.attr('id', nextNumb);
        inpClone.attr('value', '');
        $('input[name*="path"]').last().after(inpClone);
    });
})();
//-->
</script>