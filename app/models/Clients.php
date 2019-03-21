<?php
namespace app\models;

use tachyon\behaviours\Active;

/**
 * Класс модели клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Clients extends \tachyon\db\activeRecord\ActiveRecord
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

    protected static $tableName = 'clients';
    protected $pkName = 'id';
    protected $fields = ['name', 'address', 'region_id', 'telephone', 'fax', 'contact_fio', 'contact_post', 'account', 'bank', 'INN', 'KPP', 'BIK', 'sort', 'active'];
    protected $fieldTypes = [
        'id' => 'smallint',
        'region_id' => 'smallint',
        'name' => 'tinytext',
        'address' => 'tinytext',
        'telephone' => 'tinytext',
        'fax' => 'tinytext',
        'contact_fio' => 'tinytext',
        'contact_post' => 'tinytext',
        'account' => 'tinytext',
        'bank' => 'tinytext',
        'INN' => 'bigint',
        'KPP' => 'bigint',
        'BIK' => 'bigint',
        'sort' => 'smallint',
        'active' => 'enum',
    ];
    protected $attributeTypes = [
        'name' => 'input',
        'address' => 'input',
        'region_id' => 'select',
        'telephone' => 'input',
        'fax' => 'input',
        'contact_fio' => 'input',
        'contact_post' => 'input',
        'account' => 'input',
        'bank' => 'input',
        'INN' => 'input',
        'KPP' => 'input',
        'BIK' => 'input',
        'sort' => 'input',
        'active' => 'checkbox',
    ];
    protected $attributeNames = [
        'name' => 'название',
        'address' => 'адрес',
        'region_id' => 'район',
        'telephone' => 'телефон',
        'fax' => 'факс',
        'contact_fio' => 'контакт. лицо',
        'contact_post' => 'должность конт. лица',
        'account' => 'расчетный счет',
        'bank' => 'в банке',
        'INN' => 'ИНН',
        'KPP' => 'КПП',
        'BIK' => 'БИК',
        'sort' => 'порядок сортировки',
        'active' => 'активный',
    ];
    protected $defSortBy = array('sort');
    protected $entityNames = [
        'single' => 'клиент',
        'plural' => 'клиенты'
    ];
    protected $relations = [
        'region' => array('Regions', 'belongs_to', 'region_id'),
    ];

    /**
     * @var tachyon\behaviours\Active $activeBehaviour
     */
    protected $activeBehaviour;

    public function __construct(Active $activeBehaviour, ...$params)
    {
        $this->activeBehaviour = $activeBehaviour;

        parent::__construct(...$params);
    }

    public function rules(): array
    {
        return [
            'name' => array('alphaExt', 'required'),
            'address' => array('alphaExt'),
        ];
    }

    public function setSearchConditions(array $conditions=array()): Clients
    {
        $this->like($conditions, 'name');
        $this->like($conditions, 'address');
        parent::setSearchConditions($conditions);

        return $this;
    }
}
