<?php
namespace app\repositories;

use app\traits\ConditionsTrait;
use tachyon\db\dataMapper\{
    Repository, Entity
};
use tachyon\helpers\ClassHelper;
use app\interfaces\{
    HasRowsInterface, RowsRepositoryInterface
};

/**
 * @author imndsu@gmail.com
 */
class HasRowsRepository extends Repository
{
    use ConditionsTrait;

    protected RowsRepositoryInterface $rowRepository;
    /**
     * Имя поля внешнего ключа
     */
    protected mixed $rowFk = '';

    public function __construct(RowsRepositoryInterface $rowRepository, ...$params)
    {
        if (empty($this->rowFk)) {
            $this->rowFk = strtolower(substr(str_replace('Repository', '', ClassHelper::getClassName($this)), 0, -1)) . '_id';
        }
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    public function findByPk(mixed $pk): ?Entity
    {
        if (!isset($this->collection[$pk])) {
            /** @var HasRowsInterface $entity */
            if (!$entity = $this->getByPk($pk)) {
                return null;
            }
            $rows = $this->rowRepository->findAll([$this->rowFk => $pk]);
            $entity->setRows($rows);
            $this->collection[$pk] = $entity;
        }
        return $this->collection[$pk];
    }

    /**
     * Возвращает последний (максимальный) номер
     */
    public function getLastNumber(): ?int
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
     */
    public function getNextNumber(): int
    {
        return $this->getLastNumber() + 1;
    }
}
