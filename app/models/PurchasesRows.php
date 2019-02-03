<?php
namespace app\models;

/**
 * Класс модели строк фактур закупок
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class PurchasesRows extends \app\components\RowsModel
{
    use \app\traits\ArticleTrait;

    protected static $tableName = 'purchases_rows';
    protected $pkName = 'id';
    protected $fields = array('article_subcategory_id');

    protected static $parentKey = 'purchase_id';
    protected $fieldTypes = array(
        'purchase_id' => 'int',
        'article_subcategory_id' => 'smallint',
    );
    protected $relations = array(
        'article' => array('ArticleSubcats', 'has_one', 'article_subcategory_id'),
    );
}
