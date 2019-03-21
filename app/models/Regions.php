<?php
namespace app\models;

/**
 * Класс районов города
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Regions extends \tachyon\db\activeRecord\ActiveRecord
{
    use \tachyon\traits\ListTrait;
    /**
     * Поле модели, которое попадает в подпись элемента селекта
     * @var $valueField string | array
     */
    protected $valueField = 'name';
    /**
     * В случае, если $valueField - массив это строка, склеивающая возвращаемые значения
     * @var $valsGlue string
     */
    protected $valsGlue = ' :: ';
    /**
     * Поле первичного ключа модели
     * @var $pkField integer
     */
    protected $pkField = 'id';
    /**
     * Пустое значение в начале списка для селекта. Равно false если выводить не надо.
     * @var $pkField integer | boolean
     */
    protected $emptyVal = '...';

    protected static $tableName = 'regions';
    protected $pkName = 'id';
    protected $fields = array('name', 'description');

    protected $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'varchar',
        'description' => 'varchar',
    );
    protected $attributeNames = array(
        'name' => 'название',
        'description' => 'описание',
    );
    protected $attributeTypes = array(
        'name' => 'input',
        'description' => 'textarea',
    );
    protected $entityNames = array(
        'single' => 'район',
        'plural' => 'районы'
    );
}
