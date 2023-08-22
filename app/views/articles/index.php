@extends('grid')

<?php
$this->pageTitle = 'Товары, список';

$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => ['name', 'unit', 'priceFrom', 'priceTo'],
]);
?>

<table>
    <tr>
        <th style="width: 20%"><?=$entity->getCaption('subcat_id')?></th>
        <th><?=$entity->getCaption('name')?></th>
        <th style="width: 5%"><?=$entity->getCaption('unit')?></th>
        <th style="width: 5%"><?=$entity->getCaption('price')?></th>
        <th style="width: 5%"><?=$entity->getCaption('active')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getSubcatName() }}</td>
            <td>{{ $item->getName() }}</td>
            <td>{{ $item->getUnit() }}</td>
            <td>{{ $item->getPrice() }}</td>
            <td>{{ $item->getActive() }}</td>
            <td><a class="button-update" title="update" href="/articles/update/{{$item->getPk()}}"></a></td>
        </tr>
    <?php }?>
</table>
