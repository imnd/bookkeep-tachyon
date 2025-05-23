<?php

namespace app\entities;

use tachyon\db\dataMapper\Entity,
    app\interfaces\RowEntityInterface;

/**
 * Класс сущности "Позиция"
 *
 * @author imndsu@gmail.com
 */
class Row extends Entity implements RowEntityInterface
{
    /**
     * Имя поля внешнего ключа родительской записи
     *
     * @var string|null
     */
    protected ?string $rowFk = null;
    /**
     * Имя свойства внешнего ключа родительской записи
     *
     * @var string|null
     */
    protected ?string $rowFkProp = null;

    public function __construct(...$params)
    {
        $this->attributeCaptions = [
            'quantity' => 'количество',
            'price'    => 'цена',
            'sum'      => 'сумма',
        ];
        if (is_null($this->rowFk)) {
            $tableNameArr = preg_split('/(?=[A-Z])/', str_replace('Row', '', static::class));
            array_shift($tableNameArr);
            $this->rowFk = strtolower(implode('_', $tableNameArr)) . '_id';
        }
        if (is_null($this->rowFkProp)) {
            $this->rowFkProp = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->rowFk))));
        }

        parent::__construct(...$params);
    }

    /**
     * @var int
     */
    protected ?int $quantity = null;
    /**
     * @var int
     */
    protected ?int $price = null;

    # region Getters

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'numerical',
            'price'    => 'numerical',
        ];
    }

    public function getAttributes(): array
    {
        return [
            'quantity' => $this->quantity,
            'price'    => $this->price,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);
        $entity->quantity = $state['quantity'];
        $entity->price = $state['price'];
        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function getRowFk(): string
    {
        return $this->rowFk;
    }

    # endregion

    # region Setters

    public function setQuantity(int $value = null): Entity
    {
        return $this->_setAttribute('quantity', $value);
    }

    public function setPrice(int $value = null): Entity
    {
        return $this->_setAttribute('price', $value);
    }

    public function setAttributes(array $state): void
    {
        $this
            ->setQuantity($state['quantity'] ?: null)
            ->setPrice($state['price'] ?: null);
    }

    /**
     * @inheritDoc
     */
    public function setRowFkProp(int $value = null): void
    {
        $this->setAttribute($this->rowFkProp, $value);
    }

    # endregion
}
