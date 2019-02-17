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
    use \tachyon\dic\behaviours\ListBehaviour;
    use \tachyon\traits\GetList;

    protected static $tableName = 'article_subcats';
    protected $pkName = 'id';
    protected $fields = array('name', 'cat_id');

    protected $fieldTypes = array(
        'id' => 'smallint',
        'cat_id' => 'smallint',
        'name' => 'tinytext',
    );
    protected $relations = array(
        'category' => array('ArticleCats', 'belongs_to', 'cat_id'),
    );
}
