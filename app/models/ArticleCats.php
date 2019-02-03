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
    protected $pkName = 'id';
    protected static $tableName = 'article_cats';
    protected $fields = array('name', 'description');

    protected $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'varchar',
        'description' => 'varchar',
    );
}
