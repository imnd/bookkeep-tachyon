<?=$this->assetManager->css('reconciliation', 'print/css')?>
<table>
    <tr class="center bold font-size-14">
        <td colspan=8>Акт сверки</td>
    </tr>
    <tr class="center font-size-10">
        <td colspan=8>
            <p>взаимных расчетов за период: <?=$dateFrom?> — <?=$dateTo?></p>
            <p>между <?=$client->name?></p>
            <p style="padding-bottom: 12pt;">и <?=$sender->name?></p>
        </td>
    </tr>
    <tr class="justify font-size-10">
        <td colspan=8>
            <p style="padding-bottom: 18pt;">Мы, нижеподписавшиеся, <?=$client->contact_post?> <?=$client->contact_fio?> от <?=trim($client->name)?>, с одной стороны, и <?=$sender->name?>, с другой стороны, составили настоящий акт сверки в том, что состояние
  взаимных расчетов по данным учета следующее:</p>
        </td>
    </tr>
    <tr class="cell font-size-10 border-top">
        <td colspan="4">По данным <?=$client->name?>, RUB</td>
        <td colspan="4">По данным <?=$sender->name?>, RUB</td>
    </tr>
    <tr class="cell center bold font-size-9">
        <td class="date">Дата</td>
        <td class="document">Документ</td>
        <td class="debet">Дебет</td>
        <td>Кредит</td>
        <td class="date">Дата</td>
        <td class="document">Документ</td>
        <td class="debet">Дебет</td>
        <td>Кредит</td>
    </tr>
    <tr class="cell font-size-8 bold">
        <td colspan="2" class="left">Сальдо начальное</td>
        <td></td>
        <td class="right"><?=$saldoStart?></td>
        <td colspan="2" class="left">Сальдо начальное</td>
        <td class="right"><?=$saldoStart?></td>
        <td></td>
    </tr>

    <!--ФАКТУРЫ-->
    <?php foreach ($invoices as $invoice) {?>
        <tr class="cell font-size-8">
            <td><?=$invoice['date']?></td>
            <td>счет-фактура № <?=$invoice['number']?></td>
            <td></td>
            <td><?=$invoice['sum']?></td>
            <td><?=$invoice['date']?></td>
            <td>счет-фактура № <?=$invoice['number']?></td>
            <td><?=$invoice['sum']?></td>
            <td></td>
        </tr>
    <?php } ?>

    <!--ПЛАТЕЖИ-->
    <?php foreach ($bills as $bill) { ?>
        <tr class="font-size-8 cell">
            <td><?=$bill['date']?></td>
            <td>Платежное поручение <!--№ <?php //=$bill['contract_num']?>--></td>
            <td><?=$bill['sum']?></td>
            <td></td>
            <td><?=$bill['date']?></td>
            <td>Платежное поручение <!--№ <?php //=$bill->contract_num']?>--></td>
            <td></td>
            <td><?=$bill['sum']?></td>
        </tr>
    <?php }?>

    <tr class="font-size-8 bold cell">
        <td colspan=2>Обороты за период</td>
        <td><?=$creditSum?></td>
        <td><?=$debetSum?></td>
        <td colspan=2>Обороты за период</td>
        <td><?=$debetSum?></td>
        <td><?=$creditSum?></td>
    </tr>
    <tr class="font-size-8 bold cell">
        <td colspan=2>Сальдо конечное</td>
        <td><?php if ($saldo<0) echo abs($saldo)?></td>
        <td><?php if ($saldo>0) echo $saldo?></td>
        <td colspan=2>Сальдо конечное</td>
        <td><?php if ($saldo>0) echo $saldo?></td>
        <td><?php if ($saldo<0) echo abs($saldo)?></td>
    </tr>
    <tr>
        <td colspan=8></td>
    </tr>
    <tr>
        <td colspan=4 class="font-size-8">По данным <?=$client->name?></td>
        <td colspan=4 class="font-size-8">По данным <?=$sender->name?></td>
    </tr>
    <tr>
        <td colspan=4 class="font-size-8 bold" style="padding-right: 24pt;">на <?=$dateTo?>&nbsp;задолженность&nbsp;<?php
        if ($saldo!==0) {
            ?>в пользу <?php if ($saldo>0) {
                echo $sender->name;
            } elseif ($saldo<0) {
                echo $client->name;
            }?> составляет <?=abs($saldo)?>&nbsp;руб<?php
        } else {
            ?>отсутствует<?php
        }
        ?>.</td>
        <td colspan=4 class="font-size-8 bold">на <?=$dateTo?>&nbsp;задолженность&nbsp;<?php
        if ($saldo!==0) {
            ?>в пользу <?php if ($saldo>0) {
                echo $sender->name;
            } elseif ($saldo<0) {
                echo $client->name;
            }?> составляет <?=abs($saldo)?>&nbsp;руб<?php
        } else {
            ?>отсутствует<?php
        }
        ?>.</td>
    </tr>
    <tr>
        <td colspan=8></td>
    </tr>
    <tr class="font-size-8">
        <td colspan=3>От <?=$client->name?></td>
        <td></td>
        <td colspan=3>От <?=$sender->name?></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr class="font-size-8">
        <td colspan=2 class="border-bottom"><?=$client->contact_fio?></td>
        <td>(_______________________)</td>
        <td></td>
        <td colspan=2 class="border-bottom"><?=$sender->director?></td>
        <td>(_______________________)</td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr class="font-size-8">
        <td colspan=2>Главный бухгалтер</td>
        <td></td>
        <td></td>
        <td colspan=2>Главный бухгалтер</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan=8></td>
    </tr>
    <tr class="font-size-8">
        <td colspan=2 class="border-bottom"></td>
        <td>(_______________________)</td>
        <td></td>
        <td colspan=2 class="border-bottom"></td>
        <td>(_______________________)</td>
        <td></td>
    </tr>
    <tr class="font-size-10">
        <td>М.П.</td>
        <td></td>
        <td></td>
        <td></td>
        <td>М.П.</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>