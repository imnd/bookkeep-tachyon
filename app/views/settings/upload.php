<script type="text/javascript" src="/assets/js/dom.js"></script>
<script type="text/javascript" src="/assets/js/ajax.js"></script>
<script type="text/javascript" src="/assets/js/upload.js"></script>
<form>
    <input type="file" id="file" />
    <input type="button" id="file-upload" value="Отправить" />&nbsp;
    <span id="complete" style="color: green;"></span>
</form>
<script><!--
    Upload.defaults({
        "chunk-size" : 120000,
        "file-id" : "file",
        "upload-url" : "/settings/acceptFile",
        "complete-callback" : function() {
            dom.findById('complete').innerHTML = 'Готово';
        },
    });
    dom.findById('file-upload').addEventListener('click', Upload.run, false);
//--></script>
</html>