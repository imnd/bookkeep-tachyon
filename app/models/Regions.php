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
    use \tachyon\dic\behaviours\ListBehaviour,
        \tachyon\traits\GetList;

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
