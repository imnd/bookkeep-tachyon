@extends('grid')

<?php
use tachyon\View;
use app\entities\Invoice;
use app\entities\Client;

/**
 * @var View $this
 * @var Invoice $entity
 * @var Invoice[] $items
 * @var Client[] $clients
 */

$this->pageTitle = 'Список фактур';

// фильтр
$this->display('../blocks/search-form', [
    'entity' => $entity,
    'fields' => [
        'dateFrom' => ['type' => 'date'],
        'dateTo' => ['type' => 'date'],
        'number',
        'contract_num',
        [
            'name' => 'client_id',
            'type' => 'select',
            'options' => $clients,
        ]
    ],
]);
$this->display('list', compact('entity', 'items'))
?>

<script type="module">
    import bindSortHandlers from '/assets/js/grid-sort.mjs'
    bindSortHandlers(["number", "date", "contract", "sum"], "invoices-list", "/invoices/grid");
</script>

