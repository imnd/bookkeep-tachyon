<!DOCTYPE html>
<html lang="<?=$this->controller->getLanguage()?>">
<head>
    <title><?=$this->pageTitle ?? 'Бухгалтерия'?></title>
    <meta http-equiv="content-type" content="text/html; charset=<?=$this->config->get('encoding')?>" />
    <?=
    $this->assetManager->css('style'),
    $this->assetManager->coreJs('dom')
    ?>
</head>

<body class="<?="{$this->controller->getId()} {$this->controller->getAction()}"?>">
    <div class="main" id="menu">
        <?php
        $this->widget([
            'class' => 'app\components\widgets\menu\Menu',
            'items' => [
                'invoices' => 'фактуры',
                'contracts' => 'договоры и контракты',
                'purchases' => 'закупки',
                'articles' => 'товары',
                'clients' => 'клиенты',
                'bills' => 'платежи',
                'settings' => 'администрирование',
                'index/' . ($this->controller->isAuthorised() ? 'logout' : 'login') => $this->controller->isAuthorised() ? 'выйти' : 'войти',
            ],
            'viewsPath' => 'top',
        ]);
        $this->widget([
            'class' => 'app\components\widgets\menu\Menu',
            'items' => $this->controller->getMainMenu(),
            'viewsPath' => 'main',
        ]);
        ?>
    </div>
    <div class="clear"></div>
    <div id="container">
        <?php $this->widget([
            'class' => 'app\components\widgets\menu\Menu',
            'items' => $this->controller->getSubMenu(),
            'viewsPath' => 'sub',
        ])?>
        <h1><?=$this->pageTitle?></h1>

        <div class="messages">
            <?php foreach ($this->flash->getAllFlashes() as $type => $message) {?>
                <div class="<?=$type?>"><?=$message?></div>
            <?php }?>
        </div>
