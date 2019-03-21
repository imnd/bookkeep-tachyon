<?php
namespace app\models;

/**
 * Класс модели категорий товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleCats extends \tachyon\db\activeRecord\ActiveRecord
{
    protected static $tableName = 'article_cats';
    protected $pkName = 'id';
    protected $fields = array('name', 'description');
    protected $fieldTypes = [
        'id' => 'smallint',
        'name' => 'varchar',
        'description' => 'varchar',
    ];
}
