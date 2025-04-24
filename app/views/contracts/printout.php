<h1>Приложение №1 к <?=$typeName?>у №<?=$contract->getContractNum()?> от <?=$contract->getDay()?> <?=$contract->getMonth()?> <?=$contract->getYear()?> г.<br />
Спецификация поставки продуктов питания <?=$term?>
</h1>
<?php
$rows = $contract->getRows();
$totalSum = 0;
if (count($rows) > 0) {?>
<table class="bill">
    <tr class="hat">
        <th class="short">№<br />п/п</th>
        <th class="long">Наименование продукции</th>
        <th class="short">Ед. изм.</th>
        <th class="short">Кол-во</th>
        <th class="short">Цена&nbsp;за&nbsp;ед. без&nbsp;НДС, руб.</th>
        <th class="short">Сумма без&nbsp;НДС, руб.</th>
        <th class="short">Ставка НДС, %</th>
        <th class="short">Сумма&nbsp;НДС, руб.</th>
        <th class="short">Всего с&nbsp;НДС, руб.</th>
        <th class="short">Цена&nbsp;за&nbsp;ед. с&nbsp;НДС,&nbsp;руб.</th>
        <th>Срок поставки</th>
    </tr>
    <?php
    $i = $sum = $quantity = 0;
    $artCatDescr = $rows[0]['cat_description'] ?? '';
    $this->display('_artCat', compact('artCatDescr'));
    foreach ($rows as $row) {
        if ($artCatDescr!==$row['cat_description']) {
            $artCatDescr = $row['cat_description'];
            $this->display('_total', compact('quantity', 'sum'));
            $this->display('_artCat', compact('artCatDescr'));
            $i = $sum = $quantity = 0;
        }
        $rowSum = round($row['price']*$row['quantity'], 2);
        $sum += $rowSum;
        $totalSum += $rowSum;
        $rowSum = number_format($rowSum, 2, '.', '');
        ?>
        <tr class="row">
            <td class="cell center"><?=++$i?></td>
            <td class="article"><?=$row['art_name']?></td>
            <td><?=$row['art_unit']?></td>
            <td class="quantity"><?=$row['quantity']?></td>
            <td class="price"><?=$row['price']?></td>
            <td class="sum"><?=$rowSum?></td>
            <td class="center">-</td>
            <td class="center">-</td>
            <td class="sum"><?=$rowSum?></td>
            <td class="price"><?=$row['price']?></td>
            <td><?=$term?></td>
        </tr>
        <?php
        $quantity += $row['quantity'];
    }
    $totalSum = number_format($totalSum, 2, '.', '');
    $this->display('_total', compact('quantity', 'sum'));
    ?>
    <tr class="total">
        <td colspan="3"><b>Всего: </b></td>
        <td><?=$quantitySum?></td>
        <td></td>
        <td><?=$totalSum?></td>
        <td colspan="2"></td>
        <td><?=$totalSum?></td>
        <td colspan="2"></td>
    </tr>
</table>
<?php }?>
<div class="footer">
    <div>
        Всего: <span id="total-sum-in-words"><?=$totalSum?></span>.&nbsp;
        НДС не взимается по ст.346 глава 26.2 Налогового Кодекса РФ
    </div>
    <table>
        <tr>
            <td><b>Покупатель:</b>&nbsp;<?=$contract->getClientName()?></td>
            <td><b>Поставщик:</b> <?=$firm->name?></td>
        </tr>
        <tr>
            <td><b><?=$contract->getClientContactPost()?>:</b>&nbsp;___________&nbsp;<?=$contract->getClientContactFio()?></td>
            <td><b>Директор:</b>&nbsp;___________<?=$firm->director?></td>
        </tr>
        <tr>
            <td>М.П.</td>
            <td>М.П.</td>
        </tr>
        <tr>
            <td>ИНН:&nbsp;<?=$contract->getClientINN()?></td>
            <td>ИНН:&nbsp;<?=$firm->INN?></td>
        </tr>
        <?php /*
        <tr>
            <td>Л/счет:&nbsp;<?=$contract->client->account?></td>
            <td></td>
        </tr>
        */?>
    </table>
</div>

<script type="module" src="/assets/js/printout-contract.mjs"></script>
