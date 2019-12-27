<?php
namespace app\interfaces;

use Iterator,
    tachyon\db\dataMapper\Entity,
    tachyon\db\dataMapper\Repository
;

interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getTableName();

    /**
     * Устанавливает условия поиска для хранилища
     * 
     * @param array $conditions условия поиска
     * @return Repository
     */
    public function setSearchConditions($conditions = array());

    /**
     * Устанавливает условия сортировки для хранилища.
     * 
     * @param array $attrs
     * @return Repository
     */
    public function setSort($attrs);

    /**
     * Добавляет условия сортировки для хранилища к уже существующим.
     * 
     * @param string $field
     * @param string $order
     * @return void
     */
    public function addSortBy($field, $order);

    /**
     * Получает все сущности по условию $where, отсортированных по $sort
     * и преобразовать в Iterator
     * 
     * @param array $where
     * @param array $sort
     * @return Iterator
     */
    public function findAll(array $where = array(), array $sort = array()): Iterator;

    /**
     * Получить все сущности по условию $where, отсортированных по $sort
     * в виде массива
     *
     * @param array $where
     * @param array $sort
     * @return Iterator
     */
    public function findAllRaw(array $where = array(), array $sort = array()): array;

    /**
     * Получить сущность по первичному ключу.
     * 
     * @param mixed $pk
     * @return Entity
     */
    public function findByPk($pk): ?Entity;

    /**
     * Создает новую сущность.
     *
     * @param bool $mark
     * @return Entity
     */
    public function create($mark = true): ?Entity;
}
