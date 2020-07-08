<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Article extends Entity
{
    protected $attributeCaptions = [
        'subcat_id' => 'подкатегория',
        'name' => 'название',
        'unit' => 'ед.изм.',
        'price' => 'цена',
        'priceFrom' => 'цена от',
        'priceTo' => 'цена до',
        'active' => 'активный',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $subcatId;
    /**
     * @var int
     */
    protected $subcatName;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $unit;
    /**
     * @var int
     */
    protected $price;
    /**
     * @var int
     */
    protected $active;

    # GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getSubcatId()
    {
        return $this->subcatId;
    }

    public function getSubcatName()
    {
        return $this->subcatName;
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'unit' => $this->unit,
            'price' => $this->price,
            'active' => $this->active,
            'subcat_id' => $this->subcatId,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->name = $state['name'] ?? null;
        $entity->unit = $state['unit'] ?? null;
        $entity->price = $state['price'] ?? null;
        $entity->active = $state['active'] ?? null;
        $entity->subcatId = $state['subcat_id'] ?? null;
        $entity->subcatName = $state['subcatName'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'address, unit' => 'alphaExt',
            'price, active, subcat_id' => 'integer',
        ];
    }

    # Setters

    public function setName(string $value = null): Article
    {
        return $this->_setAttribute('name', $value);
    }

    public function setUnit(string $value = null): Article
    {
        return $this->_setAttribute('unit', $value);
    }

    public function setPrice(string $value = null): Article
    {
        return $this->_setAttribute('price', $value);
    }

    public function setActive(int $value = null): Article
    {
        return $this->_setAttribute('active', $value);
    }

    public function setSubcatId(int $value = null): Article
    {
        return $this->_setAttribute('subcatId', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setName($state['name'] ?? null)
            ->setUnit($state['unit'] ?? null)
            ->setPrice($state['price'] ?? null)
            ->setActive($state['active'] ?? null)
            ->setSubcatId($state['subcat_id'] ?: null)
        ;
    }
}
