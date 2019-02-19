<?php
namespace app\models;

/**
 * Класс модели товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Articles extends \tachyon\db\activeRecord\ActiveRecord
{
    use \tachyon\dic\behaviours\Active,
        \tachyon\dic\behaviours\ListBehaviour,
        \tachyon\traits\GetList;

    protected static $tableName = 'articles';
    protected $pkName = 'id';
    protected $fields = array('subcat_id', 'name', 'unit', 'price', 'active');

    protected $fieldTypes = [
        'id' => 'smallint',
        'subcat_id' => 'smallint',
        'name' => 'tinytext',
        'unit' => 'float',
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
    // TODO: на выпил
    protected $entityNames = [
        'single' => 'товар',
        'plural' => 'товары'
    ];
    protected $relations = [
        'subcategory' => array('ArticleSubcats', 'belongs_to', 'subcat_id'),
    ];

    /**
     * @param array $conditions условия поиска
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
}
