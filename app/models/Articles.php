<?php
namespace app\models;

use tachyon\behaviours\Active;

/**
 * Класс модели товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Articles extends \tachyon\db\activeRecord\ActiveRecord
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

    protected static $tableName = 'articles';
    protected $pkName = 'id';
    protected $fields = array('subcat_id', 'name', 'unit', 'price', 'active');

    protected $fieldTypes = [
        'id' => 'smallint',
        'subcat_id' => 'smallint',
        'name' => 'tinytext',
        'unit' => 'string',
        'price' => 'tinyint',
        'active' => 'enum',
    ];
    protected $attributeNames = [
        'subcat_id' => 'подкатегория',
        'subcatName' => 'подкатегория',
        'name' => 'название',
        'unit' => 'ед.изм.',
        'price' => 'цена',
        'priceFrom' => 'цена от',
        'priceTo' => 'цена до',
        'active' => 'активный',
        'activeText' => 'активный',
    ];
    protected $defSortBy = array('name');
    protected $entityNames = [
        'single' => 'товар',
        'plural' => 'товары'
    ];
    protected $relations = [
        'subcategory' => array('ArticleSubcats', 'belongs_to', 'subcat_id'),
    ];

    /**
     * @var tachyon\behaviours\Active $activeBehaviour
     */
    protected $activeBehaviour;
    /**
     * @var tachyon\behaviours\ListBehaviour $listbehaviour
     */
    protected $listBehaviour;

    public function __construct(Active $activeBehaviour, ...$params)
    {
        $this->activeBehaviour = $activeBehaviour;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return Articles
     */
    public function setSearchConditions(array $conditions=array()): Articles
    {
        $this->gt($conditions, 'price', 'priceFrom');
        $this->lt($conditions, 'price', 'priceTo');
        parent::setSearchConditions($conditions);

        return $this;
    }

    /**
     * @return string
     */
    public function getCatDescription(): string
    {
        return $this->subcategory->category->description;
    }

    /**
     * @return string
     */
    public function getSubcatName(): string
    {
        return $this->subcategory->name;
    }

    /**
     * @return array
     */
    public function getUnits(): array
    {
        return array('кг', 'шт');
    }

    /**
     * @return tachyon\behaviours\Active
     */
    public function getActiveBehaviour()
    {
        return $this->activeBehaviour;
    }
}
