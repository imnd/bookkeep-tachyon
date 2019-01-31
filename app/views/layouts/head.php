<!DOCTYPE html>
<html lang="<?=$this->controller->getLanguage()?>">
<head>
	<title><?=$this->pageTitle?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?=$this->config->getOption('encoding')?>" />
    <?=
    $this->assetManager->css('style'),
    $this->assetManager->coreJs('dom')
    ?>
</head>

<body class="<?="{$this->controller->getId()} {$this->controller->getAction()}"?>">
	<div class="main" id="menu">
        <?php
        $this->widget([
            'class' => 'Menu',
            'items' => [
                'invoices' => 'фактуры',
                'contracts' => 'договоры и контракты',
                'purchases' => 'закупки',
                'articles' => 'товары',
                'clients' => 'клиенты',
                'bills' => 'платежи',
                'settings' => 'администрирование',
            ],
            'view' => 'top',
        ]);
        $this->widget([
            'class' => 'Menu',
            'items' => $this->controller->getMainMenu(),
            'view' => 'main',
        ]);
        ?>
    </div>
    <div class="clear"></div>
    <div id="container">
        <?php $this->widget([
            'class' => 'Menu',
            'items' => $this->controller->getSubMenu(),
            'view' => 'sub',
        ])?>
        <h1><?=$this->pageTitle?></h1>

        <div class="messages">
            <?php foreach (\tachyon\helpers\FlashHelper::getAll() as $type => $message) {?>
                <div class="<?=$type?>"><?=$message?></div>
            <?php }?>
        </div>
