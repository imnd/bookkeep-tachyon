<?php
foreach ($items as $key => $value) {
    $type = null;
    if (is_numeric($key)) {
        if (is_array($value)) {
            if (!isset($value['action']))
                throw new Exception('Property "action" in menu is undetermined.');

            if (isset($value['type']))
                $type = $value['type'];

            $callback = (isset($value['callback'])) ? $value['callback'] : '';
            $confirmMsg = isset($value['confirmMsg']) ? $value['confirmMsg'] : 'уверены?';
            $action = $value['action'];
            $title = isset($value['title']) ? $value['title'] : '';
        } else {
            $action = $value;
            $title = '';
        }
    } else {
        $action = $key;
        $title = $value;
    }
    $buttonClass = (empty($title)) ? 'center' : 'left';
    ?>
    <a class="button <?=$buttonClass;?> <?=(strpos($action, '/')!==false) ? substr($action, 0, strpos($action, '/')) : $action;?>" title="<?=$title;?>" href="<?=$widget->getBtnHref($action);?>" id="<?=$widget->getBtnId($action);?>"><?=$title;?></a>
    <?php if (!is_null($type) && $type==='ajax') {?>
    <?=$this->assetManager->coreJs("ajax")?>
    <script><!--
    dom.findById('<?=$widget->getBtnId($action);?>').addEventListener("click", function(e) {
        e.preventDefault();
        if (confirm("<?=$confirmMsg;?>")!==true)
            return false;

        ajax.post(
            '<?=$widget->getBtnHref($action);?>',
            {<?="'{$controller->tokenId}':'{$controller->tokenVal}',"?>},
            function(data) {
                if (data.success==true)
                    <?=$callback;?>
            }
        );
        return false;
    });
    //--></script>
    <?php
    }
}