<?php
/**
 * @var app\entities\Client $client
 * @var app\entities\Region[] $regions
 * @var app\entities\Region $region
 */
?>
<form method="POST" action="<?=request()->getRoute()?>">
    <div class="row">
        <label><?=$client->getCaption('name')?>*:</label>
        <input name="name" value="<?=$client->getName()?>" class="required" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('address')?>:</label>
        <input name="address" value="<?=$client->getAddress()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('region_id')?>:</label>
        <select name="region_id" value="<?=$client->getRegionId()?>">
            <option value="">...</option>
            <?php foreach ($regions as $region) {?>
                <option value="<?=$region->getId()?>" <?php if ($region->getId()==$client->getRegionId()) {?>selected<?php }?>><?=$region->getName()?></option>
            <?php }?>
        </select>
    </div>
    <div class="row">
        <label><?=$client->getCaption('telephone')?>:</label>
        <input name="telephone" value="<?=$client->getPhone()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('fax')?>:</label>
        <input name="fax" value="<?=$client->getFax()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('contact_fio')?>:</label>
        <input name="contact_fio" value="<?=$client->getContactFullName()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('contact_post')?>:</label>
        <input name="contact_post" value="<?=$client->getContactPost()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('account')?>:</label>
        <input name="account" value="<?=$client->getAccount()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('bank')?>:</label>
        <input name="bank" value="<?=$client->getBank()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('INN')?>:</label>
        <input name="INN" value="<?=$client->getINN()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('KPP')?>:</label>
        <input name="KPP" value="<?=$client->getKPP()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('BIK')?>:</label>
        <input name="BIK" value="<?=$client->getBIK()?>" type="text">
    </div>
    <div class="row">
        <label><?=$client->getCaption('sort')?>:</label>
        <input name="sort" value="<?=$client->getSort()?>" type="text">
    </div>

    <input type="submit" class="button" value="сохранить">
    <div class="clear"></div>
</form>
