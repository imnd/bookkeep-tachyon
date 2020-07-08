<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    tachyon\db\dataMapper\Entity,
    tachyon\traits\ClassName,
    app\interfaces\RowsRepositoryInterface
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class HasRowsRepository extends Repository
{
    use ClassName;

    /**
     * @var Repository
     */
    protected $rowRepository;
    /**
     * @var mixed Имя поля внешнего ключа
     */
    protected $rowFk;

    /**
     * @param RowsRepositoryInterface $rowRepository
     * @param array $params
     */
    public function __construct(RowsRepositoryInterface $rowRepository, ...$params)
    {
        if (is_null($this->rowFk)) {
            $this->rowFk = substr(strtolower(str_replace('Repository', '', $this->getClassName())), 0, -1) . '_id';
        }
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * @inheritdoc
     */
    public function findByPk($pk): ?Entity
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
