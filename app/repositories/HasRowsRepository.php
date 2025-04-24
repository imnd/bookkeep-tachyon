<?php
namespace app\repositories;

use ErrorException;
use ReflectionException;
use tachyon\db\dataMapper\{
    Repository, Entity
};
use tachyon\exceptions\DBALException;
use tachyon\traits\ClassName;
use app\interfaces\HasRowsInterface;
use app\interfaces\RowsRepositoryInterface;

/**
 * @author imndsu@gmail.com
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
     * @param array                   $params
     *
     * @throws ReflectionException
     */
    public function __construct(RowsRepositoryInterface $rowRepository, ...$params)
    {
        if (is_null($this->rowFk)) {
            $this->rowFk = strtolower(substr(str_replace('Repository', '', $this->getClassName()), 0, -1)) . '_id';
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
            $rows = $this->rowRepository->findAll([$this->rowFk => $pk]);
            /** @var HasRowsInterface $entity */
            if (!$entity = $this->getByPk($pk)) {
                return null;
            }
            $entity->setRows($rows);
            $this->collection[$pk] = $entity;
        }
        return $this->collection[$pk];
    }

    /**
     * Возвращает последний (максимальный) номер
     *
     * @return integer
     * @throws ErrorException|DBALException
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
     *
     * @return integer
     * @throws ErrorException|DBALException
     */
    public function getNextNumber(): int
    {
        return $this->getLastNumber() + 1;
    }
}
