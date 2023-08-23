<?php
use app\entities\Invoice;

/**
 * @var Invoice $entity
 * @var Invoice[] $items
 */
?>
<table id="invoices-list" class="data-grid">
    <tr>
        <th id="number"><?=$entity->getCaption('number')?></th>
        <th id="date" style="width: 18%"><?=$entity->getCaption('date')?></th>
        <th id="client"><?=$entity->getCaption('clientName')?></th>
        <th id="contract"><?=$entity->getCaption('contractNum')?></th>
        <th id="sum"><?=$entity->getCaption('sum')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getNumber() }}</td>
            <td>{{ $item->getDate() }}</td>
            <td>{{ $item->getClientNameAndAddress() }}</td>
            <td>{{ $item->getContractNum() }}</td>
            <td>{{ $item->getSum() }}</td>
            <td><a class="button-update" title="редактировать" href="/invoices/update/{{ $item->getPk()}}"></a></td>
            <td><a class="button-printout" title="распечатать фактуру" href="/invoices/printout/{{$item->getPk()}}/type/bill"></a></td>
            <td><a class="button-printout" title="распечатать накладную" href="/invoices/printout/{{$item->getPk()}}/type/invoice"></a></td>
        </tr>
    <?php }?>
</table>
