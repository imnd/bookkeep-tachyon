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

    public static $tableName = 'purchases_rows';
    public static $primKey = 'id';
    public static $fields = array('article_subcategory_id');

    protected static $parentKey = 'purchase_id';
    protected static $fieldTypes = array(
        'purchase_id' => 'int',
        'article_subcategory_id' => 'smallint',
    );
    protected $relations = array(
        'article' => array('ArticleSubcats', 'has_one', 'article_subcategory_id'),
    );
}
