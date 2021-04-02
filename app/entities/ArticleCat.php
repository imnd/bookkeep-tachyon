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
    protected int $id;
    /**
     * @var string
     */
    protected string $name;
    /**
     * @var string
     */
    protected string $description;

    # Getters

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * @param array $state
     *
     * @return Entity
     */
    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->name = $state['name'] ?? null;
        $entity->description = $state['description'] ?? null;

        return $entity;
    }

    /**
     * @return array|\string[][]
     */
    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'description' => ['alphaExt'],
        ];
    }

    # SETTERS

    /**
     * @param string|null $value
     *
     * @return ArticleCat
     */
    public function setName(string $value = null): ArticleCat
    {
        return $this->_setAttribute('name', $value);
    }

    /**
     * @param string|null $value
     *
     * @return ArticleCat
     */
    public function setDescription(string $value = null): ArticleCat
    {
        return $this->_setAttribute('description', $value);
    }

    /**
     * @param array $state
     */
    public function setAttributes(array $state)
    {
        $this
            ->setName($state['name'] ?? null)
            ->setDescription($state['description'] ?? null)
        ;
    }
}
