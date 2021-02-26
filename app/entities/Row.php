<?php

namespace app\entities;

use tachyon\db\dataMapper\Entity,
    app\interfaces\RowEntityInterface;

/**
 * Класс сущности "Клиент"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Row extends Entity implements RowEntityInterface
{
    /**
     * @var mixed
     */
    protected $rowFk;

    public function __construct(...$params)
    {
        $this->attributeCaptions = [
            'quantity' => 'количество',
            'price'    => 'цена',
            'sum'      => 'сумма',
        ];
        if (is_null($this->rowFk)) {
            $tableNameArr = preg_split('/(?=[A-Z])/', str_replace('Row', '', get_called_class()));
            array_shift($tableNameArr);
            $this->rowFk = strtolower(implode('_', $tableNameArr)) . '_id';
        }
        parent::__construct(...$params);
    }

    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var int
     */
    protected $price;

    # Getters
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
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
     * @return mixed
     */
    public function getRowFk()
    {
        return $this->rowFk;
    }

    # Setters
    public function setQuantity(int $value = null): Entity
    {
        return $this->_setAttribute('quantity', $value);
    }

    public function setPrice(int $value = null): Entity
    {
        return $this->_setAttribute('price', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setQuantity($state['quantity'] ?: null)
            ->setPrice($state['price'] ?: null);
    }
}
