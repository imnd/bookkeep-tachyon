<?php
$this->layout = 'list';
$this->pageTitle = 'Платежи, список';

$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => [
        'dateFrom' => ['type' => 'date'],
        'dateTo' => ['type' => 'date'],
        'contract_num',
        [
            'name' => 'client_id',
            'type' => 'select',
            'options' => $clients,
            'style' => 'width: 300px',
        ]
    ],
]);
?>

<table>
    <tr>
        <th style="width: 5%"><?=$entity->getCaption('contents')?></th>
        <th style="width: 10%"><?=$entity->getCaption('contractNum')?></th>
        <th style="width: 60%"><?=$entity->getCaption('clientName')?></th>
        <th style="width: 5%"><?=$entity->getCaption('sum')?></th>
        <th style="width: 5%"><?=$entity->getCaption('remainder')?></th>
        <th style="width: 10%"><?=$entity->getCaption('date')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getContentsReadable() }}</td>
            <td>{{ $item->getContractNum() }}</td>
            <td>{{ $item->getClientName() }}</td>
            <td>{{ $item->getSum() }}</td>
            <td>{{ $item->getRemainder() }}</td>
            <td>{{ $item->getDate() }}</td>
            <td class="operations"><a class="button-update" title="update" href="/bills/update/<?=$item->getPk()?>"></a></td>
        </tr>
    <?php }?>
</table>
