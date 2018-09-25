<?php
namespace app\models;

/**
 * Класс модели настроек приложения
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Settings extends \tachyon\db\models\ArModel
{
    public static $tableName = 'settings';
    public static $primKey = 'id';
    public static $fields = array('name', 'key', 'value');

    protected static $fieldTypes = array(
        'id' => 'smallint',
        'name' => 'tinytext',
        'key' => 'tinytext',
        'value' => 'tinytext',
    );
    protected static $attributeTypes = array(
        'name' => 'input',
        'key' => 'input',
        'value' => 'input',
    );
    protected static $attributeNames = array(
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
     * getRequisites
     * Реквизиты фирмы
     * 
     * @param $from string какой фирмы
     * @return array
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
     * findByKey
     * 
     * @param $key string
     * @return \tachyon\db\models\ArModel
     */
    public function findByKey($key)
    {
        return $this->findOneByAttrs(compact('key'));
    }

    /**
     * @param $key string
     * @return array
     */
    public function getByKey($key)
    {
        return $this->getOne(compact('key'));
    }

    /**
     * getValueByKey
     * 
     * @param $key string
     * @return string
     */
    public function getValueByKey($key)
    {
        $row = $this->getByKey($key);
        return $row['value'];
    }

    /**
     * getNameByKey
     * 
     * @param $key string
     * @return string
     */
    public function getNameByKey($key)
    {
        $row = $this->getByKey($key);
        return $row['name'];
    }
}
