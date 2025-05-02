@extends('grid')

<?php
/**
 * @var View $this
 */

use tachyon\View;

if (!is_null($type)) {
    $this->setOption('bodyClass', $this->getOption('bodyClass') . " $type");
} else {
    $this->setOption('bodyClass', 'contracts_and_agreements');
}
$this->pageTitle = "Список {$entity->getTypeName($type, 'gen')}";

// фильтр
$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => ['dateFrom', 'dateTo', 'contract_num', [
        'name' => 'client_id',
        'type' => 'select',
        'options' => $clients,
    ]],
]);
?>

<table>
    <tr>
        <th><?=$entity->getCaption('contractNum')?></th>
        <th style="width: 6%"><?=$entity->getCaption('date')?></th>
        <th><?=$entity->getCaption('termStart')?></th>
        <th><?=$entity->getCaption('termEnd')?></th>
        <th><?=$entity->getCaption('clientName')?></th>
        <th><?=$entity->getCaption('sum')?></th>
        <th><?=$entity->getCaption('executed')?></th>
        <th><?=$entity->getCaption('execRemind')?></th>
        <th><?=$entity->getCaption('payed')?></th>
        <th><?=$entity->getCaption('payedRemind')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td><?=$item->getContractNum()?></td>
            <td><?=$item->getDate()?></td>
            <td><?=$item->getTermStart()?></td>
            <td><?=$item->getTermEnd()?></td>
            <td><?=$item->getClientNameAndAddress()?></td>
            <td><?=$item->getSum()?></td>
            <td><?=$item->getExecuted()?></td>
            <td><?=$item->getExecRemind()?></td>
            <td><?=$item->getPayed()?></td>
            <td><?=$item->getPayedRemind()?></td>
            <td><a class="button-update" title="update" href="/contracts/update/<?=$item->getId()?>"></a></td>
            <td><a class="button-printout" title="распечатать" href="printout/<?=$item->getId()?>"></a></td>
        </tr>
    <?php }?>
</table>
