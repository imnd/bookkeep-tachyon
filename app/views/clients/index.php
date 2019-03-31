<?php
$this->layout = 'list';
$this->pageTitle = 'Клиенты, список';

$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => ['name', 'address'],
]);
?>

<table>
    <tr>
        <th><?=$entity->getCaption('name')?></th>
        <th><?=$entity->getCaption('address')?></th>
        <th><?=$entity->getCaption('telephone')?></th>
        <th><?=$entity->getCaption('fax')?></th>
        <th><?=$entity->getCaption('contactFullName')?></th>
        <th><?=$entity->getCaption('contactPost')?></th>
        <th><?=$entity->getCaption('bank')?></th>
        <th><?=$entity->getCaption('account')?></th>
        <th><?=$entity->getCaption('INN')?></th>
        <th><?=$entity->getCaption('KPP')?></th>
        <th><?=$entity->getCaption('BIK')?></th>
        <th>операции</th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getName() }}</td>
            <td>{{ $item->getAddress() }}</td>
            <td>{{ $item->getPhone() }}</td>
            <td>{{ $item->getFax() }}</td>
            <td>{{ $item->getContactFullName() }}</td>
            <td>{{ $item->getContactPost() }}</td>
            <td>{{ $item->getBank() }}</td>
            <td>{{ $item->getAccount() }}</td>
            <td>{{ $item->getINN() }}</td>
            <td>{{ $item->getKPP() }}</td>
            <td>{{ $item->getBIK() }}</td>
            <td><a class="button-update" title="update" href="/clients/update/{{$item->getPk()}}"></a></td>
        </tr>
    <?php }?>
</table>
