<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ArticleSubcat extends Entity
{
    protected $attributeCaptions = [
        'cat_id' => 'категория',
        'name' => 'название',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $catId;
    /**
     * @var string
     */
    protected $name;

    # GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCatId()
    {
        return $this->catId;
    }

    public function getCatName()
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

    # Setters

    public function setName(string $value = null): Article
    {
        return $this->_setAttribute('name', $value);
    }

    public function setCatId(int $value = null): Article
    {
        return $this->_setAttribute('catId', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setName($state['name'] ?? null)
            ->setCatId($state['cat_id'] ?: null)
        ;
    }
}
