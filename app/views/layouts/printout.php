<!DOCTYPE html>
<html lang="<?=$this->controller->getLanguage()?>">
<head>
    <meta charset="utf-8">
    <title><?=$this->pageTitle?></title>

    <?= $this->assetManager->css('style', 'print/css') ?>
</head>
<body class="print <?=$this->controller->getId()?>">
    <div id="container">
        @contents

<?php $this->display('../layouts/foot')?>