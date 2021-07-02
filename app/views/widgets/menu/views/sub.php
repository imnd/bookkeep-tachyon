<?php
foreach ($items as $key => $value) {
    $type = null;
    if (is_numeric($key)) {
        if (is_array($value)) {
            if (!isset($value['action'])) {
                throw new ErrorException(i18n('Property "action" in menu is undetermined.'));
            }
            if (isset($value['type'])) {
                $type = $value['type'];
            }
            $callback = $value['callback'] ?? '';
            $confirmMsg = $value['confirmMsg'] ?? 'уверены?';
            $action = $value['action'];
            $title = $value['title'] ?? '';
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
    <a class="button <?=$buttonClass?> <?=(strpos($action, '/')!==false) ? substr($action, 0, strpos($action, '/')) : $action?>" title="<?=$title?>" href="<?=$widget->getBtnHref($action)?>" id="<?=$widget->getBtnId($action)?>"><?=$title?></a>
    <?php if ($type==='ajax') {?>
    <script>
        import dom from '/assets/js/dom.js';
        import ajax from '/assets/js/ajax.js';

        dom.findById('<?=$widget->getBtnId($action)?>').addEventListener("click", e => {
        e.preventDefault();
        if (confirm("<?=$confirmMsg?>")!==true) {
            return false;
        }
        ajax.post(
            '<?=$widget->getBtnHref($action)?>',
            {<?="'{$controller->tokenId}':'{$controller->tokenVal}',"?>},
            data => {
                if (data.success===true) {
                    <?=$callback?>
                }
            }
        );
        return false;
    });
    </script>
    <?php
    }
}
