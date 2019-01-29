<table>
    <tr>
        <td><?=$entity->getAttributeCaption('name')?></td>
        <td><?=$entity->getAttributeCaption('address')?></td>
        <td><?=$entity->getAttributeCaption('telephone')?></td>
        <td><?=$entity->getAttributeCaption('fax')?></td>
        <td><?=$entity->getAttributeCaption('contactFullName')?></td>
        <td><?=$entity->getAttributeCaption('contactPost')?></td>
        <td><?=$entity->getAttributeCaption('bank')?></td>
        <td><?=$entity->getAttributeCaption('account')?></td>
        <td><?=$entity->getAttributeCaption('INN')?></td>
        <td><?=$entity->getAttributeCaption('KPP')?></td>
        <td><?=$entity->getAttributeCaption('BIK')?></td>
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
        </tr>
        <?php 
    }?>
</table>
