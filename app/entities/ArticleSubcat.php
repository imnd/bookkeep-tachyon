<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Подкатегория продукта"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ArticleSubcat extends Entity
{
    protected array $attributeCaptions = [
        'cat_id' => 'категория',
        'name' => 'название',
    ];

    /**
     * @var int
     */
    protected int $id;
    /**
     * @var int
     */
    protected int $catId;
    /**
     * @var string
     */
    protected string $name;

    # region getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCatId(): int
    {
        return $this->catId;
    }

    public function getCatName(): int
    {
        return $this->catId;
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'cat_id' => $this->catId,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->name = $state['name'] ?? null;
        $entity->catId = $state['cat_id'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'cat_id' => 'integer',
        ];
    }

    # endregion

    # SETTERS

    /**
     * @param string|null $value
     *
     * @return ArticleSubcat
     */
    public function setName(string $value = null): ArticleSubcat
    {
        return $this->_setAttribute('name', $value);
    }

    /**
     * @param int|null $value
     *
     * @return ArticleSubcat
     */
    public function setCatId(int $value = null): ArticleSubcat
    {
        return $this->_setAttribute('catId', $value);
    }

    /**
     * @param array $state
     */
    public function setAttributes(array $state): void
    {
        $this
            ->setName($state['name'] ?? null)
            ->setCatId($state['cat_id'] ?: null)
        ;
    }

    # endregion
}
