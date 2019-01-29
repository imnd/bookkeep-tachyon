<?php 
/** @var app\entities\Client $client */
/** @var app\entities\Region $region */
?>
<form method="POST" action="<?=$this->getController()->getRoute()?>">
    <div class="row">
        <label>название*:</label>
        <input name="name" value="<?=$client->getName()?>" class="required" type="text">
    </div>
    <div class="row">
        <label>адрес:</label>
        <input name="address" value="<?=$client->getAddress()?>" type="text">
        </div>
    <div class="row">
        <label>район:</label>
        <select name="region_id" value="<?=$client->getRegionId()?>">
            <option value="">...</option>
            <?php foreach ($regions as $region) {?>
                <option value="<?=$region->getId()?>" <?php if ($region->getId()==$client->getRegionId()) {?>selected<?php }?>><?=$region->getName()?></option>
            <?php }?>
        </select>
    </div>
    <div class="row">
        <label>телефон:</label>
        <input name="telephone" value="<?=$client->getPhone()?>" type="text">
    </div>
    <div class="row">
        <label>факс:</label>
        <input name="fax" value="<?=$client->getFax()?>" type="text">
    </div>
    <div class="row">
        <label>контакт. лицо:</label>
        <input name="contact_fio" value="<?=$client->getContactFullName()?>" type="text">
    </div>
    <div class="row">
        <label>должность конт. лица:</label>
        <input name="contact_post" value="<?=$client->getContactPost()?>" type="text">
    </div>
    <div class="row">
        <label>расчетный счет:</label>
        <input name="account" value="<?=$client->getAccount()?>" type="text">
    </div>
    <div class="row">
        <label>в банке:</label>
        <input name="bank" value="<?=$client->getBank()?>" type="text">
    </div>
    <div class="row">
        <label>ИНН:</label>
        <input name="INN" value="<?=$client->getINN()?>" type="text">
    </div>
    <div class="row">
        <label>КПП:</label>
        <input name="KPP" value="<?=$client->getKPP()?>" type="text">
    </div>
    <div class="row">
        <label>БИК:</label>
        <input name="BIK" value="<?=$client->getBIK()?>" type="text">
    </div>
    <div class="row">
        <label>порядок сортировки:</label>
        <input name="sort" value="<?=$client->getSort()?>" type="text">
    </div>

    <input type="submit" class="button" value="сохранить">
    <div class="clear"></div>
</form>
