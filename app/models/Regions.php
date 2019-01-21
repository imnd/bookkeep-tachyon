<?php
namespace app\models;

/**
 * Класс районов города
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Regions extends \tachyon\db\models\ActiveRecord
{
    use \tachyon\dic\behaviours\ListBehaviour;
    use \tachyon\traits\GetList;

    public static $tableName = 'regions';
    public static $primKey = 'id';
    public static $fields = array('name', 'description');

    protected static $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'varchar',
        'description' => 'varchar',
    );
    protected static $attributeNames = array(
        'name' => 'название',
        'description' => 'описание',
    );
    protected static $attributeTypes = array(
        'name' => 'input',
        'description' => 'textarea',
    );
    protected $entityNames = array(
        'single' => 'район',
        'plural' => 'районы'
    );
}
