<?php

namespace app\models;

use tachyon\db\activeRecord\ActiveRecord;
use tachyon\exceptions\DBALException;

/**
 * Класс модели настроек приложения
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Settings extends ActiveRecord
{
    protected static string $tableName = 'settings';
    protected string $pkName = 'id';

    protected array $fields = ['name', 'key', 'value'];
    protected array $fieldTypes = [
        'id'    => 'smallint',
        'name'  => 'tinytext',
        'key'   => 'tinytext',
        'value' => 'tinytext',
    ];
    protected array $attributeTypes = [
        'name'  => 'input',
        'key'   => 'input',
        'value' => 'input',
    ];
    protected array $attributeNames = [
        'name'  => 'название',
        'key'   => 'ключ',
        'value' => 'значение',
    ];

    public function rules(): array
    {
        return [
            'key, value'       => ['required'],
            'name, value, key' => ['alphaExt'],
        ];
    }

    /**
     * Реквизиты фирмы
     *
     * @param $from string какой фирмы
     *
     * @return object
     */
    public function getRequisites($from)
    {
        $firm = [];
        $keys = [
            'director',
            'name_short',
            'name',
            'address',
            'certificate',
            'INN',
            'KPP',
            'OKUD',
            'OKPO',
            'bank',
            'account',
        ];
        foreach ($keys as $key) {
            $firm[$key] = $this->getValueByKey("{$from}_$key");
        }
        return (object)$firm;
    }

    /**
     * @param string $key
     *
     * @return ActiveRecord
     * @throws DBALException
     */
    public function findByKey(string $key): ActiveRecord
    {
        return $this->findOne(compact('key'));
    }

    /**
     * @param string $key
     *
     * @return array
     * @throws DBALException
     */
    public function getByKey(string $key): array
    {
        return $this->findOneRaw(compact('key'));
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws DBALException
     */
    public function getValueByKey(string $key): string
    {
        $row = $this->getByKey($key);
        return $row['value'] ?? '';
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws DBALException
     */
    public function getNameByKey(string $key): string
    {
        $row = $this->getByKey($key);
        return $row['name'] ?? '';
    }

    /**
     * Пути для сохранения бэкапов
     *
     * @return array
     * @throws DBALException
     */
    public function getPaths(): array
    {
        return [
            $this->getValueByKey('path0'),
            $this->getValueByKey('path1'),
        ];
    }
}
