<p class="hat">В редакции  постановления Правительства  РФ от 11.05.2006 г. № 283</p>
<p class="heading">СЧЕТ ФАКТУРА № <?=$item->getNumber()?> от: <?=$item->convDateToReadable($item->getDate(), '-')?></p>
<p class="head">Продавец: <?=$sender->name?></p>
<p class="head">Адрес: <?=$sender->address?> ИНН продавца: <?=$sender->INN?></p>
<p class="head">Грузоотправитель и его адрес: <?=$sender->name?> <?=$sender->address?></p>
<p class="head">Грузополучатель и его адрес: <?=$item->getClientName()?> <?=$item->getClientAddress()?></p>
<p class="head">К платежно-расчетному документу №___________ от___________</p>
<p class="head">Покупатель: <?=$item->getClientName()?> <?=$item->getClientAddress()?></p>
<p class="head">ИНН/КПП покупателя: <?=$item->getClientINN()?>/<?=$item->getClientKPP()?></p>
<table class="bill">
    <tr class="hat">
        <th>Наименование товара (описание выполненных работ, оказанных услуг), имущественного права</th>
        <th>Ед. изм.</th>
        <th>Кол-во</th>
        <th>Цена (тариф за ед.изм.)</th>
        <th>Стоимость товаров (работ, услуг), имущественных прав, всего без налога</th>
        <th>Стоимость товаров (работ, услуг), имущественных прав, всего с учетом  налога</th>
    </tr>
    <tr class="hat">
        <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td>
    </tr>
    <?php foreach ($item->getRows() as $row) { ?>
    <tr class="row">
        <td class="article"><?=$row->getArticleName()?></td>
        <td><?=$row->getArticleUnit()?></td>
        <td class="quantity"><?=$row->getQuantity()?></td>
        <td class="price"><?=$row->getPrice()?></td>
        <td class="sum"><?=$row->getSum()?></td>
        <td class="sum"><?=$row->getSum()?></td>
    </tr>
    <?php } ?>
    <tr class="total">
        <td colspan="5"><b>Всего к оплате: </b></td>
        <td><?=$item->getSum()?></td>
    </tr>
</table>
<div class="bill footer">
    <div>
        <p class="head">Индивидуальный предприниматель ________________ <?=$sender->director?></p>
        <p class="hat"><span>подпись</span><span>Ф.И.О.</span></p>
    </div>
    <div>
        <p class="head" style="text-align: right"><?=$sender->certificate?></p>
        <p class="hat">Реквизиты свидетельства о гос. Регистрации индивидуального предпринимателя</p>
    </div>
</div>

