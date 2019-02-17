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
            <td><?=$this->escape( $client->getName() )?></td>
            <td><?=$this->escape( $client->getAddress() )?></td>
            <td><?=$this->escape( $client->getPhone() )?></td>
            <td><?=$this->escape( $client->getFax() )?></td>
            <td><?=$this->escape( $client->getContactFullName() )?></td>
            <td><?=$this->escape( $client->getContactPost() )?></td>
            <td><?=$this->escape( $client->getBank() )?></td>
            <td><?=$this->escape( $client->getAccount() )?></td>
            <td><?=$this->escape( $client->getINN() )?></td>
            <td><?=$this->escape( $client->getKPP() )?></td>
            <td><?=$this->escape( $client->getBIK() )?></td>
            <td><a class="button-update" title="update" href="/clients/update/<?=$client->getId()?>"></a></td>
        </tr>
    <?php }?>
</table>
