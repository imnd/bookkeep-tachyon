<?php
/**
 * @var View $this
 * @var Invoice $entity
 */

use app\entities\Invoice;
use tachyon\View;

$this->layout = 'list';
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
<table>
    <tr>
        <th><?=$entity->getCaption('number')?></th>
        <th style="width: 18%"><?=$entity->getCaption('date')?></th>
        <th><?=$entity->getCaption('clientName')?></th>
        <th><?=$entity->getCaption('contractNum')?></th>
        <th><?=$entity->getCaption('sum')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getNumber() }}</td>
            <td>{{ $item->getDate() }}</td>
            <td>{{ $item->getClientNameAndAddress() }}</td>
            <td>{{ $item->getContractNum() }}</td>
            <td>{{ $item->getSum() }}</td>
            <td><a class="button-update" title="редактировать" href="update/{{$item->getPk()}}"></a></td>
            <td><a class="button-printout" title="распечатать фактуру" href="printout/{{$item->getPk()}}/type/bill"></a></td>
            <td><a class="button-printout" title="распечатать накладную" href="printout/{{$item->getPk()}}/type/invoice"></a></td>
        </tr>
    <?php }?>
</table>
