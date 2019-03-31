<?php
// сопоставление интерфейсов зависимостей с реализацией
$implementations = array();
foreach ([
    'Article',
    'ArticleCat',
    'ArticleSubcat',
    'Bill',
    'Client',
    'Contract',
    'ContractRow',
    'Invoice',
    'InvoiceRow',
    'Purchase',
    'PurchaseRow',
    'Region',
    'Settings',
] as $entity) {
    $implementations["app\\interfaces\\{$entity}RepositoryInterface"] = "app\\repositories\\{$entity}Repository";
}
return $implementations;