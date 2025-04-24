<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Подкатегория продукта"
 *
 * @author imndsu@gmail.com
 */
class ArticleSubcat extends Entity
{
    protected array $attributeCaptions = [
        'cat_id' => 'категория',
        'name' => 'название',
    ];

    protected int $id;
    protected int $catId;
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

    public function setName(string $value = null): ArticleSubcat
    {
        return $this->_setAttribute('name', $value);
    }

    public function setCatId(int $value = null): ArticleSubcat
    {
        return $this->_setAttribute('catId', $value);
    }

    public function setAttributes(array $state): void
    {
        $this
            ->setName($state['name'] ?? null)
            ->setCatId($state['cat_id'] ?: null)
        ;
    }

    # endregion
}
