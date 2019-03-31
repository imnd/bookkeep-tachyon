<?php
namespace app\models;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 * 
 * class RowsModel
 * Класс модели строк табличного документа
 */
class RowsModel extends \tachyon\db\activeRecord\ActiveRecord
{
    protected $parentKey = '';

    public function __construct(...$params)
    {
        $this->fields = array_merge($this->fields, array($this->parentKey, 'quantity', 'price'));
        $this->fieldTypes = array_merge($this->fieldTypes, [
            'id' => 'int',
            $this->parentKey => 'int',
            'quantity' => 'double',
            'price' => 'double',
        ]);
        $this->attributeTypes = array_merge($this->attributeTypes, [
            'quantity' => 'input',
            'price' => 'input',
        ]);
        $this->attributeNames = array_merge($this->attributeNames, [
            'quantity' => 'количество',
            'price' => 'цена',
        ]);

        parent::__construct(...$params);
    }

    public function rules(): array
    {
        return [
            'quantity' => array('numerical'),
            'price' => array('numerical'),
        ];
    }

    /**
     * getSum
     * 
     * @return integer
     */
    public function getSum(): int
    {
        return number_format($this->quantity * $this->price, 2, '.', '');
    }
}