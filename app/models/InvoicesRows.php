<?php
namespace app\models;

/**
 * Класс модели строки фактуры
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoicesRows extends RowsModel
{
    use \app\traits\Article;

    protected static $tableName = 'invoices_rows';
    protected $pkName = 'id';
    protected $fields = array('article_id');

    protected $parentKey = 'invoice_id';
    protected $fieldTypes = [
        'article_id' => 'smallint',
        'quantity' => 'smallint',
        'price' => 'smallint',
    ];
    protected $attributeTypes = [
        'article_id' => 'select',
        'quantity' => 'input',
        'price' => 'input',
    ];
    protected $attributeNames = [
        'article_id' => 'товар',
        'quantity' => 'количество',
        'price' => 'цена',
    ];
    protected $relations = [
        'article' => array('Articles', 'has_one', 'article_id'),
    ];

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'article_id' => array('numerical'),
        ]);
    }
}
