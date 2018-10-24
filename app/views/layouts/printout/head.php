<!DOCTYPE html>
<html lang="<?=$this->controller->getLanguage()?>">
<head>
    <meta charset="utf-8">
    <title><?=$this->pageTitle?></title>

    <link rel="stylesheet" type="text/css" href="/assets/print/css/style.css" />
    <?=$this->assetManager->publishJs("dom")?>
    <script type="text/javascript" src="/assets/print/js/utils.js"></script>
</head>
<body class="print <?=$this->controller->getId()?>">
    <div id="container">