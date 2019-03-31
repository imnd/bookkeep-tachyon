<?php
/**
 * @var \tachyon\View $this
 */
$this->layout = 'list';
$this->pageTitle = 'Список поставок';

// фильтр
$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => [
        'dateFrom' => ['type' => 'date'],
        'dateTo' => ['type' => 'date'],
        'number',
    ],
]);
?>
<table>
    <tr>
        <th><?=$entity->getCaption('number')?></th>
        <th style="width: 18%"><?=$entity->getCaption('date')?></th>
        <th><?=$entity->getCaption('sum')?></th>
    </tr>
    <?php foreach ($items as $item) {?>
        <tr>
            <td>{{ $item->getNumber() }}</td>
            <td>{{ $item->getDate() }}</td>
            <td>{{ $item->getSum() }}</td>
            <td><a class="button-update" title="редактировать" href="update/{{$item->getPk()}}"></a></td>
            <td><a class="button-printout" title="распечатать" href="printout/{{$item->getPk()}}"></a></td>
        </tr>
    <?php }?>
</table>
