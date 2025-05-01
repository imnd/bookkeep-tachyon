<!DOCTYPE html>
<html lang="<?=lang()->getLanguage()?>">
<head>
    <title><?=$this->pageTitle?></title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <?= $this->assetManager->css('style')?>
</head>

<body>
<div class="main" id="menu">
</div>
<div class="clear"></div>
<div id="container">
    @contents
</div>
</body>
</html>
