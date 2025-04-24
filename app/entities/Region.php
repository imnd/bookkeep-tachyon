<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Регион"
 *
 * @author imndsu@gmail.com
 */
class Region extends Entity
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    # region Getters

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAttributes(): array
    {
        return [];
    }

    # endregion

    # region Setters

    public function setId(int $value): Entity
    {
        $this->id = $value;
        return $this;
    }

    public function setName(string $value): Entity
    {
        $this->name = $value;
        return $this;
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);
        $entity
            ->setId($state['id'] ?? null)
            ->setName($state['name'] ?? null)
        ;
        return $entity;
    }

    public function setAttributes(array $state): void
    {

    }

    # endregion
}
