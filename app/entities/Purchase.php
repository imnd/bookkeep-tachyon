<?php

namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Поставка"
 *
 * @author imndsu@gmail.com
 */
class Purchase extends Entity
{
    protected array $attributeCaptions = [
        'number'   => 'номер',
        'date'     => 'дата',
        'sum'      => 'сумма',
        'dateFrom' => 'дата с',
        'dateTo'   => 'дата по',
    ];

    /**
     * @var int|null
     */
    protected ?int $id;
    /**
     * @var string|null
     */
    protected ?string $number;
    /**
     * @var string|null
     */
    protected ?string $date;
    /**
     * @var float|null
     */
    protected ?float $sum;

    # region Getters

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function getAttributes(): array
    {
        return [
            'number' => $this->number,
            'date'   => $this->date,
            'sum'    => $this->sum,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);
        $entity->id = $state['id'] ?? null;
        $entity->number = $state['number'] ?? null;
        $entity->date = $state['date'] ?? null;
        $entity->sum = $state['sum'] ?? null;
        return $entity;
    }

    public function rules(): array
    {
        return [
            'date, number' => 'required',
            'number'       => 'numerical',
        ];
    }

    # endregion

    # region Setters

    /**
     * @param null $value
     *
     * @return Purchase
     */
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

    public function setAttributes(array $state): void
    {
        $this
            ->setNumber($state['number'] ?? null)
            ->setDate($state['date'] ?? null)
            ->setSum($state['sum'] ?? null);
    }

    # endregion
}
