@extends('grid')

<?php
/**
 * @var View $this
 * @var Invoice $entity
 */

use app\entities\Invoice;
use tachyon\View;

$this->pageTitle = 'Список фактур';

// фильтр
$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => [
        'dateFrom' => ['type' => 'date'],
        'dateTo' => ['type' => 'date'],
        'number',
        'contract_num',
        [
            'name' => 'client_id',
            'type' => 'select',
            'options' => $clients,
        ]
    ],
]);
?>

<script type="module">
    import bindSortHandlers from '/assets/js/grid-sort.mjs'
    bindSortHandlers(["number", "date"], "invoices-list", "/invoices");
</script>

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
