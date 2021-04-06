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
    /**
     * @inheritDock
     */
    protected array $attributeCaptions = [
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
    protected int $id;
    /**
     * @var int
     */
    protected int $subcatId;
    /**
     * @var string
     */
    protected string $subcatName;
    /**
     * @var string
     */
    protected ?string $name = null;
    /**
     * @var string
     */
    protected ?string $unit = null;
    /**
     * @var int
     */
    protected ?int $price = null;
    /**
     * @var int
     */
    protected int $active;

    # GETTERS

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getSubcatId(): int
    {
        return $this->subcatId;
    }

    /**
     * @return string
     */
    public function getSubcatName(): string
    {
        return $this->subcatName;
    }

    /**
     * @return array
     */
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
        $entity->unit = $state['unit'] ?? null;
        $entity->price = $state['price'] ?? null;
        $entity->active = $state['active'] ?? null;
        $entity->subcatId = $state['subcat_id'] ?? null;
        $entity->subcatName = $state['subcatName'] ?? null;

        return $entity;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'address, unit' => 'alphaExt',
            'price, active, subcat_id' => 'integer',
        ];
    }

    # SETTERS

    /**
     * @param string|null $value
     *
     * @return Article
     */
    public function setName(string $value = null): Article
    {
        return $this->_setAttribute('name', $value);
    }

    /**
     * @param string|null $value
     *
     * @return Article
     */
    public function setUnit(string $value = null): Article
    {
        return $this->_setAttribute('unit', $value);
    }

    /**
     * @param string|null $value
     *
     * @return Article
     */
    public function setPrice(string $value = null): Article
    {
        return $this->_setAttribute('price', $value);
    }

    /**
     * @param int|null $value
     *
     * @return Article
     */
    public function setActive(int $value = null): Article
    {
        return $this->_setAttribute('active', $value);
    }

    /**
     * @param int|null $value
     *
     * @return Article
     */
    public function setSubcatId(int $value = null): Article
    {
        return $this->_setAttribute('subcatId', $value);
    }

    /**
     * @param array $state
     *
     * @return Article
     */
    public function setAttributes(array $state): Article
    {
        return $this
            ->setName($state['name'] ?? null)
            ->setUnit($state['unit'] ?? null)
            ->setPrice($state['price'] ?? null)
            ->setActive($state['active'] ?? null)
            ->setSubcatId($state['subcat_id'] ?: null)
        ;
    }
}
