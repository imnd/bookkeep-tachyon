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
    use \app\traits\Article;

    protected static $tableName = 'invoices_rows';
    protected $pkName = 'id';
    protected $fields = array('article_id');

    protected $parentKey = 'invoice_id';
    protected $fieldTypes = array(
        'article_id' => 'smallint',
    );
    protected $attributeTypes = array(
        'article_id' => 'select',
    );
    protected $attributeNames = array(
        'article_id' => 'товар',
    );
    protected $relations = array(
        'article' => array('Articles', 'has_one', 'article_id'),
    );

    public function rules(): array
    {
        return array_merge(parent::rules(), array(
            'article_id' => array('numerical'),
        ));
    }
}
