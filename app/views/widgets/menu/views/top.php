<ul class="top_menu">
    <?php
    $i = 0;
    foreach ($items as $controller => $title) { ?>
        <li class="<?=$controller;?> <?php if ($i===0) {
            ?>left<?php
        } elseif ($i===count($items)-1) {
            ?>right<?php
        }?>"><a href='/<?=$controller;?>/'><?=$title;?></a></li>
        <?php
        $i++;
    } ?>
</ul>