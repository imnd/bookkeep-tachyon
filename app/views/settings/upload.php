<?= 
$this->assetManager->publishJs("dom"),
$this->assetManager->publishJs("ajax"),
$this->assetManager->publishJs("upload")
?>
<form>
    <input type="file" id="file" />
    <input type="button" id="file-upload" value="Отправить" />&nbsp;
    <span id="complete" style="color: green;"></span>
</form>
<script><!--
    upload.defaults({
        "chunk-size" : 600000,
        "file-id" : "file",
        "upload-url" : "/settings/acceptFile",
        "complete-callback" : function() {
            dom.findById('complete').innerHTML = 'Готово';
        },
    });
    dom.findById('file-upload').addEventListener('click', upload.run, false);
//--></script>
</html>