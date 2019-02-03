<?php
namespace app\models;

/**
 * Класс модели настроек приложения
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Settings extends \tachyon\db\activeRecord\ActiveRecord
{
    protected static $tableName = 'settings';
    protected $pkName = 'id';
    protected $fields = array('name', 'key', 'value');

    protected $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'tinytext',
        'key' => 'tinytext',
        'value' => 'tinytext',
    );
    protected $attributeTypes = array(
        'name' => 'input',
        'key' => 'input',
        'value' => 'input',
    );
    protected $attributeNames = array(
        'name' => 'название',
        'key' => 'ключ',
        'value' => 'значение',
    );

    public function rules(): array
    {
        return array(
            'key, value' => array('required'),
            'name, value, key' => array('alphaExt'),
        );
    }

    /**
     * Реквизиты фирмы
     * 
     * @param $from string какой фирмы
     * @return object
     */
    public function getRequisites($from)
    {
        $firm = array();
        $keys = array('director', 'name_short', 'name', 'address', 'certificate', 'INN', 'KPP', 'OKUD', 'OKPO', 'bank', 'account');
        foreach ($keys as $key)
            $firm[$key] = $this->getValueByKey("{$from}_$key");

        return (object)$firm;
    }

    /**
     * @param $key string
     * @return \tachyon\db\activeRecord\ActiveRecord
     */
    public function findByKey($key)
    {
        return $this->findOne(compact('key'));
    }

    /**
     * @param $key string
     * @return array
     */
    public function getByKey($key)
    {
        return $this->findOneScalar(compact('key'));
    }

    /**
     * @param $key string
     * @return string
     */
    public function getValueByKey($key)
    {
        $row = $this->getByKey($key);
        return $row['value'];
    }

    /**
     * @param $key string
     * @return string
     */
    public function getNameByKey($key)
    {
        $row = $this->getByKey($key);
        return $row['name'];
    }

    /**
     * Пути для сохранения бэкапов
     * 
     * @return array
     */
    public function getPaths()
    {
        return array(
            $this->getValueByKey('path0'),
            $this->getValueByKey('path1'),
        );
    }
}
