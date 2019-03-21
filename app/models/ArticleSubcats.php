<?php
namespace app\models;

/**
 * Класс модели подкатегорий товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleSubcats extends \tachyon\db\activeRecord\ActiveRecord
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
    protected $valsGlue = ', ';
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

    protected static $tableName = 'article_subcats';
    protected $pkName = 'id';
    protected $fields = array('name', 'cat_id');
    protected $fieldTypes = [
        'id' => 'smallint',
        'cat_id' => 'smallint',
        'name' => 'tinytext',
    ];
    protected $relations = [
        'category' => array('ArticleCats', 'belongs_to', 'cat_id'),
    ];
}
