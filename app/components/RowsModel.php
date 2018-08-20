<?php
namespace app\components;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 * 
 * class RowsModel
 * Класс модели строк табличного документа
 */
class RowsModel extends \tachyon\db\models\ArModel
{
    protected static $parentKey = '';

    public function __construct()
    {
        static::$fields = array_merge(static::$fields, array(static::$parentKey, 'quantity', 'price'));
        static::$fieldTypes = array_merge(static::$fieldTypes, array(
            'id' => 'int',
            static::$parentKey => 'int',
            'quantity' => 'double',
            'price' => 'double',
        ));
        static::$attributeTypes = array_merge(static::$attributeTypes, array(
            'quantity' => 'input',
            'price' => 'input',
        ));
        static::$attributeNames = array_merge(static::$attributeNames, array(
            'quantity' => 'количество',
            'price' => 'цена',
        ));

        parent::__construct();
    }

    public function rules()
    {
        return array(
            'quantity' => array('numerical'),
            'price' => array('numerical'),
        );
    }

    /**
     * getSum
     * 
     * @return integer
     */
    public function getSum()
    {
        return number_format($this->quantity * $this->price, 2, '.', '');
    }
}