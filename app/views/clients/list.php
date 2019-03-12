<?php
$this->layout = 'list';
$this->pageTitle = 'Клиенты, список';

echo $this->display('../_search-form', [
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
    <?php foreach ($clients as $client) {?>
        <tr>
            <td>{{ $client->getName() }}</td>
            <td>{{ $client->getAddress() }}</td>
            <td>{{ $client->getPhone() }}</td>
            <td>{{ $client->getFax() }}</td>
            <td>{{ $client->getContactFullName() }}</td>
            <td>{{ $client->getContactPost() }}</td>
            <td>{{ $client->getBank() }}</td>
            <td>{{ $client->getAccount() }}</td>
            <td>{{ $client->getINN() }}</td>
            <td>{{ $client->getKPP() }}</td>
            <td>{{ $client->getBIK() }}</td>
            <td><a class="button-update" title="update" href="/clients/update/{{$client->getId()}}"></a></td>
        </tr>
    <?php }?>
</table>
