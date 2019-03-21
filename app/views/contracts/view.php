<?php
if (empty($this->controller->getSubMenu())) {
    $this->controller->setSubMenu(array(
        array(
            'action' => "delete/$pk",
            'type' => 'ajax',
            'confirmMsg' => 'удалить?',
            'callback' => "window.location='/{$this->id}/'",
        ),
        "printout/$pk",
    ));
}
?>
<h2>
    <b>от:</b> <?=$model->convDateToReadable($model->date)?><br />
    <b>клиент:</b> <?=$model->getClientName()?><br />
    <b>№ договора:</b> <a href="/contracts/contract/<?=$model->getContractId()?>"><?=$model->contract_num?></a>
</h2>
<table>
    <tr>
        <th>Наименование</th>
        <th>Ед.</th>
        <th>Кол-во</th>
        <th>Цена</th>
        <th>Сумма</th>
    </tr>
    <?php foreach ($model->rows as $row) {?>
        <tr class="row">
            <td class="article"><?=$row->getArticleName()?></td>
            <td><?=$row->getArticleUnit()?></td>
            <td class="quantity"><?=$row->quantity?></td>
            <td class="price"><?=$row->price?></td>
            <td class="sum"><?=$row->sum?></td>
        </tr>
    <?php }?>
    <tr class="total">
        <td colspan="4"><b><?=$model->getAttributeName('sum')?>: </b></td>
        <td class="total"><?=$model->sum?></td>
    </tr>
    <tr class="payed">
        <td colspan="4"><b><?=$model->getAttributeName('payed')?>: </b></td>
        <td><?=$model->payed?></td>
    </tr>
</table>