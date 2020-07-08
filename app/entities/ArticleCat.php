<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ArticleCat extends Entity
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $description;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->name = $state['name'] ?? null;
        $entity->description = $state['description'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'description' => ['alphaExt'],
        ];
    }

    # Setters

    public function setName(string $value = null): ArticleCat
    {
        return $this->_setAttribute('name', $value);
    }

    public function setDescription(string $value = null): ArticleCat
    {
        return $this->_setAttribute('description', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setName($state['name'] ?? null)
            ->setDescription($state['description'] ?? null)
        ;
    }
}
