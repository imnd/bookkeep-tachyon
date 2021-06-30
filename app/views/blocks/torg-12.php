<script type="module">
    import dom from '/assets/js/dom.js';
    dom.clear();
</script>

<?php use \tachyon\helpers\DateTimeHelper;?>
<?=$this->assetManager->css('torg-12', 'print/css')?>

<table cellspacing="0">
    <colgroup>
        <col width="7" />
        <col width="111" />
        <col width="258" />
        <col width="104" />
        <col width="104" />
        <col width="259" />
        <col width="98" />
        <col width="18" />
        <col width="49" />
        <col width="78" />
    </colgroup>
    <tbody>
        <tr class="R0">
            <td class="R0C9" colspan="10" line-height="40pt">
                <span style="white-space:nowrap">Унифицированная форма № ТОРГ-12<br />
                Утверждена постановлением Госкомстата России от 25.12.98 № 132</span></td>
            <td></td>
        </tr>
        <tr>
            <td class="R1C0"></td>
            <td class="R1C0"></td>
            <td class="R1C0"></td>
            <td class="R1C0"></td>
            <td class="R1C0"></td>
            <td class="R1C0"></td>
            <td></td>
            <td class="R1C7"></td>
            <td class="R1C7"></td>
            <td class="R1C9"><span style="white-space:nowrap">Коды</span></td>
            <td></td>
        </tr>
        <tr>
            <td class="R1C0"></td>
            <td rowspan="2" class="R3C7">Грузоотправитель</td>
            <td colspan="4" rowspan="2" class="R2C1"><?=$sender->name?>, ИНН <?=$sender->INN?>, <?=$sender->address?>, р/с <?=$sender->account?>, в банке <?=$sender->bank?><!--, БИК <?php //echo $sender->bik?>, к/с {$Otpravitel.Kor_schet}--></td>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap">Форма по ОКУД </span></td>
            <td class="R2C9"><span style="white-space:nowrap">0330212</span></td>
            <td></td>
        </tr>
        <tr>
            <td class="R3C0"></td>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap;">по ОКПО</span></td>
            <td class="R3C9"></td>
            <td></td>
        </tr>
        <tr class="R4">
            <td class="R4C0"></td>
            <td class="R3C7"></td>
            <td colspan="4" class="R4C0"><span class="R8C2" style="white-space:nowrap">организация, адрес, телефон, факс, банковские реквизиты</span></td>
            <td colspan="3"></td>
            <td class="R3C9"></td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="2" class="R3C0"></td>
            <td rowspan="2" class="R3C7">Грузополучатель</td>
            <td colspan="4" rowspan="2" class="R2C1">
                <?=$item->getClientName()?>, ИНН <?=$item->getClientINN()?>, <?=$item->getClientAddress()?>, р/с <?=$item->getClientAccount()?>, в банке <?=$item->getClientBank()?><?php //, БИК <?=$item->getClientBIK()?></td>
            <td colspan="3" class="R2C7">Вид деятельности по ОКДП</td>
            <td class="R3C9"></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap">по ОКПО</span></td>
            <td class="R3C9"><!--{$Poluchatel.OKPO}--></td>
        </tr>
        <tr class="R4">
            <td class="R8C0"></td>
            <td class="R8C1"></td>
            <td colspan="4" class="R4C0"><span style="white-space:nowrap">организация, адрес, телефон, факс, банковские реквизиты</span></td>
            <td colspan="3"></td>
            <td rowspan="3" class="R3C9"><?=$sender->OKPO?></td>
            <td></td>
        </tr>
        <tr>
            <td class="R3C7"></td>
            <td rowspan="2" class="R3C7"><span class="R3C7" style="white-space:nowrap">Поставщик</span></td>
            <td class="R2C1" colspan="4" rowspan="2">
                <?=$sender->name?>, ИНН <?=$sender->INN?>, <?=$sender->address?>, р/с <?=$sender->account?>, в банке <?=$sender->bank?><?php //, БИК <?=$sender->bik?><!--, к/с $sender->kor_schet}--></td>
            <td colspan="3"></td>
            <td></td>
        </tr>
        <tr class="R4">
            <td class="R8C0"></td>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap">по ОКПО</span></td>
            <td></td>
        </tr>
        <tr class="R4">
            <td class="R8C0"></td>
            <td class="R8C1"></td>
            <td colspan="4" class="R4C0"><span class="R8C2" style="white-space:nowrap">организация, адрес, телефон, факс, банковские реквизиты</span></td>
            <td colspan="3"></td>
            <td rowspan="3" class="R3C9"><!--{$Poluchatel.OKPO}--></td>
            <td></td>
        </tr>

        <tr>
            <td class="R3C7"></td>
            <td rowspan="2" class="R3C7"><span style="white-space:nowrap">Плательщик</span></td>
            <td colspan="4" rowspan="2" class="R2C1"> <?=$item->getClientName()?>, ИНН <?=$item->getClientINN()?>, <?=$item->getClientAddress()?>, р/с <?=$item->getClientAccount()?>, в банке <?=$item->getClientBank()?><?php /*, БИК <?=$item->getClientBIK()?>, к/с <?=$item->getClientCorrSchet()?> */?></td>
            <td colspan="3"></td>
            <td></td>
        </tr>
        <tr>
            <td class="R3C7"></td>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap">по ОКПО</span></td>
            <td></td>
        </tr>
        <tr class="R4">
            <td class="R8C0"></td>
            <td class="R8C1"></td>
            <td colspan="4" class="R4C0"><span class="R8C2" style="white-space:nowrap">организация, адрес, телефон, факс, банковские реквизиты</span></td>
            <td class="R2C7"></td>
            <td></td>
            <td rowspan="2" class="R14C8"><span style="white-space:nowrap">номер</span></td>
            <td rowspan="2" class="R8C9"></td>
            <td></td>
        </tr>
        <tr class="R5">
            <td></td>
            <td class="R3C7"><span style="white-space:nowrap">Основание</span></td>
            <td colspan="4" class="R15C2">
                <span style="white-space:nowrap"><?=$contractType?> <?php if (!empty($contractNum)) { echo "№$contractNum"; }?></span></td>
            <td rowspan="4" class="R2C7"><span>Транспортная накладная</span></td>
            <td></td>
            <td></td>
        </tr>
        <tr class="R5">
            <td></td>
            <td class="R16C1"></td>
            <td colspan="4" class="R16C2">
                <span style="white-space:nowrap">договор, заказ-наряд</span></td>
            <td></td>
            <td class="R16C8"><span style="white-space:nowrap">дата</span></td>
            <td class="R16C9">  </td>
            <td></td>
        </tr>
        <tr class="R5">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="R17C6"></td>
            <td></td>
            <td class="R16C8"><span style="white-space:nowrap">номер</span></td>
            <td class="R16C9">  </td>
            <td></td>
        </tr>
        <tr class="R5">
            <td></td>
            <td></td>
            <td></td>
            <td class="R17C3"><span style="white-space:nowrap">Номер документа</span></td>
            <td class="R17C4"><span style="white-space:nowrap">Дата составления</span></td>
            <td class="R17C6"></td>
            <td></td>
            <td class="R18C8"><span style="white-space:nowrap">дата</span></td>
            <td class="R16C9">  </td>
            <td></td>
        </tr>
        <tr class="R5">
            <td></td>
            <td></td>
            <td class="R18C2"><span style="white-space:nowrap">ТОВАРНАЯ НАКЛАДНАЯ</span></td>
            <td class="R18C3"><?=$item->getNumber()?></td>
            <td class="R18C4"><span style="white-space:nowrap"><?=$item->convDateToReadable($item->getDate(), '.', 'short')?></span></td>
            <td></td>
            <td colspan="3" class="R2C7"><span style="white-space:nowrap">Вид операции </span></td>
            <td class="R19C9"></td>
            <td></td>
        </tr>
        <tr class="R5">
            <td class="R15C1"></td>
            <td class="R15C1"></td>
            <td class="R15C1"></td>
            <td class="R15C1"></td>
            <td class="R15C1"></td>
            <td class="R15C1"></td>
            <td colspan="4" class="R2C7"></td>
            <td></td>
        </tr>
    </tbody>
</table>
<table cellspacing=0>
    <COL WIDTH="35">
    <COL WIDTH="228">
    <COL WIDTH="75">
    <COL WIDTH="59">
    <COL WIDTH="45">
    <COL WIDTH="42">
    <COL WIDTH="40">
    <COL WIDTH="40">
    <COL WIDTH="55">
    <COL WIDTH="60">
    <COL WIDTH="80">
    <COL WIDTH="90">
    <COL WIDTH="60">
    <COL WIDTH="80">
    <COL WIDTH="90">
    <tr>
        <td class=R20C15 colspan=15><span style="white-space:nowrap">Страница 1</span></td>
    </tr>
    <tr class=R21 style='page-break-inside:avoid'>
        <td class=R21C1 rowspan=2>Но- мер по по- рядку </td>
        <td class=R21C2 colspan=2><span style="white-space:nowrap">Товар</span></td>
        <td class=R21C2 colspan=2><span style="white-space:nowrap">Единица измерения</span></td>
        <td class=R21C1 rowspan=2>Вид упаков -ки</td>
        <td class=R21C2 colspan=2><span style="white-space:nowrap">Количество</span></td>
        <td class=R21C1 rowspan=2>Масса брутто</td>
        <td class=R21C2 rowspan=2><span style="white-space:nowrap">Коли-<BR>чество <BR>(масса <BR>нетто)</span></td>
        <td class=R21C2 rowspan=2><span style="white-space:nowrap">Цена,<BR>руб. коп.</span></td>
        <td class=R21C2 rowspan=2><span style="white-space:nowrap">Сумма без<BR>учета НДС,<BR>руб. коп.</span></td>
        <td class=R21C2 colspan=2><span style="white-space:nowrap">НДС</span></td>
        <td class=R21C15 rowspan=2><span style="white-space:nowrap">Сумма с<BR>учетом <BR>НДС, <BR>руб. коп.</span></td>
    </tr>
    <tr style='page-break-inside:avoid'>
        <td class=R22C2>наименование, характеристика, сорт, артикул товара</td>
        <td class=R22C3><span style="white-space:nowrap">код</span></td>
        <td class=R22C2>наимено- вание</td>
        <td class=R22C2>код по ОКЕИ</td>
        <td class=R22C2>в одном месте</td>
        <td class=R22C2>мест,<BR>штук</td>
        <td class=R22C2>ставка, %</td>
        <td class=R22C2>сумма, <BR>руб. коп.</td>
    </tr>
    <tr>
        <td class=R23C1><span style="white-space:nowrap">1</span></td>
        <td class=R23C1><span style="white-space:nowrap">2</span></td>
        <td class=R23C1><span style="white-space:nowrap">3</span></td>
        <td class=R23C1><span style="white-space:nowrap">4</span></td>
        <td class=R23C1><span style="white-space:nowrap">5</span></td>
        <td class=R23C1><span style="white-space:nowrap">6</span></td>
        <td class=R23C1><span style="white-space:nowrap">7</span></td>
        <td class=R23C1><span style="white-space:nowrap">8</span></td>
        <td class=R23C1><span style="white-space:nowrap">9</span></td>
        <td class=R23C1><span style="white-space:nowrap">10</span></td>
        <td class=R23C1><span style="white-space:nowrap">11</span></td>
        <td class=R23C1><span style="white-space:nowrap">12</span></td>
        <td class=R23C1><span style="white-space:nowrap">13</span></td>
        <td class=R23C1><span style="white-space:nowrap">14</span></td>
        <td class=R23C15><span style="white-space:nowrap">15</span></td>
    </tr>

    <?php
    $i = 0;
    foreach ($item->getRows() as $row) {?>
        <tr>
            <td class=R24C1><span style="white-space:nowrap"><?=++$i?></span></td>
            <td class=R24C2><?=$row->getArticleName()?></td>
            <td class=R24C3>-</td>
            <td class=R24C4><span style="white-space:nowrap"><?=$row->getArticleUnit()?></span></td>
            <td class=R24C5>-</td>
            <td class=R24C6>-</td>
            <td class=R24C1>-</td>
            <td class=R24C1>-</td>
            <td class=R24C1>-</td>
            <td class=R24C10><span style="white-space:nowrap"><?=$row->getQuantity()?></span></td>
            <td class=R24C10><span style="white-space:nowrap"><?=$row->getPrice()?></span></td>
            <td class=R24C10><span style="white-space:nowrap"><?=$row->getSum()?></span></td>
            <td class=R24C13><span style="white-space:nowrap">-</span></td>
            <td class=R24C14><span style="white-space:nowrap">-</span></td>
            <td class=R24C15><span style="white-space:nowrap"><?=$row->getSum()?></span></td>
        </tr>
    <?php }?>
    <tr>
        <td class=MR29C1><br></td>
        <td class=MR29C2><br></td>
        <td class=R29C3><br></td>
        <td class=MR29C0><br></td>
        <td class=R29C7 colspan=3><span style="white-space:nowrap">Итого</span></td>
        <td class=MR29C8><br></td>
        <td class=MR29C9><br></td>
        <td class=MR29C8><?=$quantitySum?></td>
        <td class=MR29C11><span style="white-space:nowrap">Х</span></td>
        <td class=MR29C12><?=$item->getSum()?></td>
        <td class=MR24C6><span style="white-space:nowrap">Х</span></td>
        <td class=MR29C12><span style="white-space:nowrap">Х</span></td>
        <td class=MR29C15><span style="white-space:nowrap"><?=$item->getSum()?></span></td>
    </tr>
    <tr>
        <td class=R3C0 colspan=7><span style="white-space:nowrap">Всего по накладной </span></td>
        <td class=R30C8><br></td>
        <td class=R30C9><br></td>
        <td class=R30C8><span style="white-space:nowrap"><?=$quantitySum?></span></td>
        <td class=R30C11><span style="white-space:nowrap">Х</span></td>
        <td class=R30C12><span style="white-space:nowrap"><?=$item->getSum()?></span></td>
        <td class=R30C11><span style="white-space:nowrap">Х</span></td>
        <td class=R30C12><span style="white-space:nowrap">Х</span></td>
        <td class=R30C15><span style="white-space:nowrap"><?=$item->getSum()?></span></td>
    </tr>
</table>
<table cellspacing=0>
    <COL WIDTH="7">
    <COL WIDTH="125">
    <COL WIDTH="91">
    <COL WIDTH="30">
    <COL WIDTH="103">
    <COL WIDTH="13">
    <COL WIDTH="138">
    <COL WIDTH="13">
    <COL WIDTH="27">
    <COL WIDTH="56">
    <COL WIDTH="42">
    <COL WIDTH="86">
    <COL WIDTH="11">
    <COL WIDTH="28">
    <COL WIDTH="21">
    <COL WIDTH="51">
    <COL WIDTH="12">
    <COL WIDTH="234">
    <tr class=R5>
        <td><br></td>
        <td><br></td>
        <td colspan=3>
            <span style="white-space:nowrap">Товарная накладная имеет приложение на </span>
        </td>
        <td class=R31C5><br></td>
        <td colspan=4 class=R5C1>счет–фактуре 1 лист</td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan=3><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr class=R21>
        <td><br></td>
        <td><br></td>
        <td><span style="white-space:nowrap">и содержит</span></td>
        <td class="R32C3" colspan="8" style="white-space:nowrap" id="items-count-1"><?=$i ?? 0?></td>
        <td colspan=8>
            <span style="white-space:nowrap">порядковых номеров записей</span>
        </td>
    </tr>
    <tr class=R4>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R33C3 colspan=8 class="handwriting">прописью</td>
        <td><br></td>
        <td><br></td>
        <td colspan=3><br></td>
        <td><br></td>
        <td class=R33C17 rowspan=2><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan=2 rowspan=2><br></td>
        <td><br></td>
        <td colspan=2><span style="white-space:nowrap">Масса груза (нетто)</span></td>
        <td class=R34C8 colspan=8 id="quantity-sum-1"><?=$quantitySum?></td>
        <td><br></td>
    </tr>
    <tr class=R4>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R33C3 colspan=8 class="handwriting">прописью</td>
        <td><br></td>
        <td class=R35C17 rowspan=2><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td><span style="white-space:nowrap">Всего мест</span></td>
        <td class="bottom-line" colspan=3 id="items-count-2"><?=$i ?? 0?></td>
        <td colspan=2><span style="white-space:nowrap">Масса груза (брутто)</span></td>
        <td class=R34C8 colspan=7 id="quantity-sum-2"><?=$quantitySum?></td>
        <td><br></td>
        <td class=R36C16><br></td>
    </tr>
    <tr class=R4>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R33C3 colspan=2>прописью</td>
        <td class=R33C3><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R33C3 colspan=8>прописью</td>
        <td><br></td>
    </tr>
    <tr class=R39>
        <td><br></td>
        <td colspan=3><span style="white-space:nowrap">Приложение (паспорта, сертификаты и т.п.) на </span></td>
        <td class=R39C4><br></td>
        <td><br></td>
        <td><span style="white-space:nowrap">листах</span></td>
        <td class=R39C7><br></td>
        <td class=R39C10 colspan=3><span style="white-space:nowrap">По доверенности №</span></td>
        <td class=R39C4><br></td>
        <td class=R39C4><br></td>
        <td class=R39C4><br></td>
        <td class=R39C14><span style="white-space:nowrap">от «        »</span></td>
        <td class=R39C4><br></td>
        <td class=R39C4><br></td>
        <td class=R39C4><br></td>
        <td><br></td>
    </tr>
    <tr class=R40>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R40C4 colspan=2>прописью</td>
        <td><br></td>
        <td class=R40C7><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan=3><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr class=R39>
        <td class=R41C0><br></td>
        <td class=R41C1 colspan=2>
            <span style="white-space:nowrap">Всего отпущено на сумму</span>
        </td>
        <td colspan=4 class="bottom-line" id="total-sum-in-words"><?=$item->getSum()?></td>
        <td class="R39C7"><br></td>
        <td><br></td>
        <td colspan=2><span style="white-space:nowrap">выданной</span></td>
        <td colspan=7 class="bottom-line"></td>
    </tr>
    <tr class=R4>
        <td colspan=3><br></td>
        <td colspan=3 class="handwriting">прописью</td>
        <td><br></td>
        <td class=R46C7><br></td>
        <td colspan=3><br></td>
        <td class=R33C3 colspan=7><span style="white-space:nowrap">кем, кому (организация, должность, фамилия, и. о.)</span></td>
        <td><br></td>
    </tr>
    <tr class=R44>
        <td><br></td>
        <td style="white-space:nowrap">Отпуск разрешил</td>
        <td class=R44C2 colspan=2><br>Руководитель организации </td>
        <td align="center" valign="bottom" class=R44C4><br></td>
        <td><br></td>
        <td valign="bottom" class=R44C6><?=$sender->director?></td>
        <td class=R44C7><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R44C6 colspan=7><br></td>
        <td><br></td>
    </tr>
    <tr class=R45>
        <td><br></td>
        <td><br></td>
        <td class=R45C2><span style="white-space:nowrap">должность</span></td>
        <td><br></td>
        <td class=R45C2><span style="white-space:nowrap">подпись</span></td>
        <td><br></td>
        <td class=R45C2><span style="white-space:nowrap">расшифровка подписи</span></td>
        <td class=R45C7><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R45C10><br></td>
        <td class=R45C2 colspan=7><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td class=R46C0><br></td>
        <td class=R46C0 colspan=3><span style="white-space:nowrap">Главный (старший) бухгалтер</span></td>
        <td align="center" class=R3C6><br></td>
        <td><br></td>
        <td class=R46C6><span style="white-space:nowrap"></span></td>
        <td class=R46C7><br></td>
        <td><br></td>
        <td colspan=2><span style="white-space:nowrap">Груз принял</span></td>
        <td class=R3C6><br></td>
        <td><br></td>
        <td class=R3C6 colspan=3><br></td>
        <td><br></td>
        <td class=R3C6><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td class=R47C2 colspan=2 rowspan=2><br></td>
        <td class=R36C16><span style="white-space:nowrap">подпись</span></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">расшифровка подписи</span></td>
        <td class=R46C7><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">должность</span></td>
        <td><br></td>
        <td class=R36C16 colspan=3><span style="white-space:nowrap">подпись</span></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">расшифровка подписи</span></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><span style="white-space:nowrap">Отпуск груза произвел</span></td>
        <td class=R3C6><br></td>
        <td><br></td>
        <td class=R46C6><br></td>
        <td class=R46C7><br></td>
        <td><br></td>
        <td colspan=2><span style="white-space:nowrap">Груз получил </span></td>
        <td class=R3C6><br></td>
        <td><br></td>
        <td class=R3C6 colspan=3><br></td>
        <td><br></td>
        <td class=R3C6><br></td>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">должность</span></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">подпись</span></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">расшифровка подписи</span></td>
        <td class=R46C7><br></td>
        <td><br></td>
        <td class=R20C0 colspan=2><span style="white-space:nowrap">грузополучатель</span></td>
        <td class=R36C16><span style="white-space:nowrap">должность</span></td>
        <td><br></td>
        <td class=R36C16 colspan=3><span style="white-space:nowrap">подпись</span></td>
        <td><br></td>
        <td class=R36C16><span style="white-space:nowrap">расшифровка подписи</span></td>
        <td><br></td>
    </tr>
    <tr class=R38>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R50C7><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
        <td colspan=3><br></td>
        <td><br></td>
        <td><br></td>
        <td><br></td>
    </tr>
    <tr class=R44>
        <td class=R51C1 colspan=2><span style="white-space:nowrap">М.П.</span></td>
        <td colspan=5 align="center" style="white-space:nowrap">«<?=$item->getDay()?>» <?=$item->getMonth()?> <?=$item->getYear()?> года</td>
        <td class=R44C7><br></td>
        <td><br></td>
        <td><br></td>
        <td class=R51C10><span style="white-space:nowrap">М.П.</span></td>
        <td><br></td>
        <td colspan=7><span style="white-space:nowrap">«<?=$item->getDay()?>» <?=$item->getMonth()?> <?=$item->getYear()?> года</span></td>
    </tr>
</table>
<script type="module">
    import dom from '/assets/js/dom.js';
    import {utils} from '/assets/print/js/utils.js';
    let itemsCount1 = dom.find('#items-count-1');
    dom.val(itemsCount1, utils.convNumToWords(dom.val(itemsCount1)));
    let itemsCount2 = dom.find('#items-count-2');
    dom.val(itemsCount2, utils.convNumToWords(dom.val(itemsCount2)));

    let quantSum1 = dom.find('#quantity-sum-1');
    dom.val(quantSum1, utils.convWeightToWords(dom.val(quantSum1)));
    let quantSum2 = dom.find('#quantity-sum-2');
    dom.val(quantSum2, utils.convWeightToWords(dom.val(quantSum2)));

    let totalSumContnr = dom.find('#total-sum-in-words');
    dom.val(totalSumContnr, utils.convPriceToWords(dom.val(totalSumContnr)));
</script>
