<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class HasRowsRepository extends Repository
{
    use \tachyon\traits\ClassName;

    /**
     * @var Repository
     */
    protected $rowRepository;
    /**
     * @var mixed Имя поля внешнего ключа
     */
    protected $rowFk;

    public function __construct(...$params)
    {
        if (is_null($this->rowFk)) {
            $this->rowFk = strtolower(str_replace('Repository', '', $this->getClassName())) . '_id';
        }

        parent::__construct(...$params);
    }

    /**
     * @inheritdoc
     */
    public function findByPk($pk)
    {
        if (!isset($this->collection[$pk])) {
            $entity = $this->getByPk($pk);
            $rows = $this->rowRepository->findAll([$this->rowFk => $pk]);
            $entity->setRows($rows);
            $this->collection[$pk] = $entity;
        }
        return $this->collection[$pk];
    }

    /**
     * Возвращает последний (максимальный) номер
     * @return integer
     * @throws \ErrorException
     */
    public function getLastNumber(): int
    {
        $item = $this
            ->persistence
            ->select('number')
            ->from($this->tableName)
            ->orderBy(['number' => 'desc'])
            ->findOne();

        return $item['number'];
    }

    /**
     * Возвращает следующий за последним (максимальным) номером
     * @return integer
     */
    public function getNextNumber(): int
    {
        return $this->getLastNumber() + 1;
    }
}
