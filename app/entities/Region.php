<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Регион"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class Region extends Entity
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    # Setters

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

    public function setAttributes(array $state)
    {
        
    }

    # Getters

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
        
    }
}
