<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Категория продукта"
 *
 * @author imndsu@gmail.com
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

    # region getters

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
     * @return array|string[][]
     */
    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'description' => ['alphaExt'],
        ];
    }

    # endregion

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
    public function setAttributes(array $state): void
    {
        $this
            ->setName($state['name'] ?? null)
            ->setDescription($state['description'] ?? null)
        ;
    }

    # endregion
}
