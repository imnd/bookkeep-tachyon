<ul class="main_menu">
    <?php
    $i = 0;
    foreach ($items as $action => $title) { ?>
        <li class="<?=str_replace('/', ' ', $action)?> <?php if ($i===0) {
            ?>left<?php
        } elseif ($i===count($items)-1) {
            ?>right<?php
        }?>"><a href="<?=$widget->getBtnHref($action)?>"><?=$title?></a></li>
        <?php
        $i++;
    }
    ?>
</ul>