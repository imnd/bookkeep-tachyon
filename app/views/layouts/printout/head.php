<!DOCTYPE html>
<html lang="<?=$this->controller->getLanguage()?>">
<head>
    <meta charset="utf-8">
    <title><?=$this->pageTitle?></title>

    <?=
    $this->assetManager->css("style", array('assets', 'print', 'css')),
    $this->assetManager->coreJs("dom"),
    $this->assetManager->js("utils", array('assets', 'print', 'js'))
    ?>
</head>
<body class="print <?=$this->controller->getId()?>">
    <div id="container">