<?php
namespace app\models;

/**
 * Класс модели категорий товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleCats extends \tachyon\db\models\ArModel
{
    public static $primKey = 'id';
    public static $tableName = 'article_cats';
    public static $fields = array('name', 'description');

    protected static $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'varchar',
        'description' => 'varchar',
    );
}
