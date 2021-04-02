<?php
use tachyon\Request;

/**
 * @var app\entities\Client $entity
 * @var app\entities\Region $region
 */
?>
<form method="POST" action="<?=Request::getRoute()?>">
    <div class="row">
        <label><?=$entity->getCaption('name')?>*:</label>
        <input name="name" value="<?=$entity->getName()?>" class="required" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('address')?>:</label>
        <input name="address" value="<?=$entity->getAddress()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('region_id')?>:</label>
        <select name="region_id" value="<?=$entity->getRegionId()?>">
            <option value="">...</option>
            <?php foreach ($regions as $region) {?>
                <option value="<?=$region->getId()?>" <?php if ($region->getId()==$entity->getRegionId()) {?>selected<?php }?>><?=$region->getName()?></option>
            <?php }?>
        </select>
    </div>
    <div class="row">
        <label><?=$entity->getCaption('telephone')?>:</label>
        <input name="telephone" value="<?=$entity->getPhone()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('fax')?>:</label>
        <input name="fax" value="<?=$entity->getFax()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('contact_fio')?>:</label>
        <input name="contact_fio" value="<?=$entity->getContactFullName()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('contact_post')?>:</label>
        <input name="contact_post" value="<?=$entity->getContactPost()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('account')?>:</label>
        <input name="account" value="<?=$entity->getAccount()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('bank')?>:</label>
        <input name="bank" value="<?=$entity->getBank()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('INN')?>:</label>
        <input name="INN" value="<?=$entity->getINN()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('KPP')?>:</label>
        <input name="KPP" value="<?=$entity->getKPP()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('BIK')?>:</label>
        <input name="BIK" value="<?=$entity->getBIK()?>" type="text">
    </div>
    <div class="row">
        <label><?=$entity->getCaption('sort')?>:</label>
        <input name="sort" value="<?=$entity->getSort()?>" type="text">
    </div>

    <input type="submit" class="button" value="сохранить">
    <div class="clear"></div>
</form>
