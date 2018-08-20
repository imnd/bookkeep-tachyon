<?php
namespace app\models;

/**
 * Класс модели строки фактуры
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoicesRows extends \app\components\RowsModel
{
    use \app\traits\ArticleTrait;

    public static $tableName = 'invoices_rows';
    public static $primKey = 'id';
    public static $fields = array('article_id');

    protected static $parentKey = 'invoice_id';
    protected static $fieldTypes = array(
        'article_id' => 'smallint',
    );
    protected static $attributeTypes = array(
        'article_id' => 'select',
    );
    protected static $attributeNames = array(
        'article_id' => 'товар',
    );
    protected $relations = array(
        'article' => array('Articles', 'has_one', 'article_id'),
    );

    public function rules()
    {
        return array_merge(parent::rules(), array(
            'article_id' => array('numerical'),
        ));
    }
}
