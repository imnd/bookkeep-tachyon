<?php
$this->setLayout('list');
$this->setPageTitle('Клиенты, список');
?>
<table>
    <tr>
        <th><?=$entity->getAttributeCaption('name')?></th>
        <th><?=$entity->getAttributeCaption('address')?></th>
        <th><?=$entity->getAttributeCaption('telephone')?></th>
        <th><?=$entity->getAttributeCaption('fax')?></th>
        <th><?=$entity->getAttributeCaption('contactFullName')?></th>
        <th><?=$entity->getAttributeCaption('contactPost')?></th>
        <th><?=$entity->getAttributeCaption('bank')?></th>
        <th><?=$entity->getAttributeCaption('account')?></th>
        <th><?=$entity->getAttributeCaption('INN')?></th>
        <th><?=$entity->getAttributeCaption('KPP')?></th>
        <th><?=$entity->getAttributeCaption('BIK')?></th>
        <th>операции</th>
    </tr>
    <?php
    // таблица
    foreach ($clients as $client) {
        ?>
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
        <?php 
    }?>
</table>
