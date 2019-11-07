<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class Purchase extends Entity
{
    protected $attributeCaptions = [
        'number' => 'номер',
        'date' => 'дата',
        'sum' => 'сумма',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $number;
    /**
     * @var string
     */
    protected $date;
    /**
     * @var float
     */
    protected $sum;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getAttributes(): array
    {
        return [
            'number' => $this->number,
            'date' => $this->date,
            'sum' => $this->sum,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['ID'];
        $entity->number = $state['number'] ?? null;
        $entity->date = $state['date'] ?? null;
        $entity->sum = $state['sum'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return [
            'date, number' => 'required',
            'number' => 'numerical',
        ];
    }

    # Setters

    public function setNumber($value = null): Purchase
    {
        return $this->_setAttribute('number', $value);
    }

    public function setDate($value = null): Purchase
    {
        return $this->_setAttribute('date', $value);
    }

    public function setSum($value = null): Purchase
    {
        return $this->_setAttribute('sum', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setNumber($state['number'] ?? null)
            ->setDate($state['date'] ?? null)
            ->setSum($state['sum'] ?? null)
        ;
    }
}
