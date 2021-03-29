<?php

namespace app\entities;

use
    tachyon\db\dataMapper\Entity,
    tachyon\traits\DateTime,
    app\interfaces\HasRowsInterface,
    app\traits\HasClient,
    app\traits\HasContract,
    app\traits\HasRows;

/**
 * Класс сущности "Фактра"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Invoice extends Entity implements HasRowsInterface
{
    use HasClient, HasContract, HasRows, DateTime;

    protected array $attributeCaptions = [
        'number'       => 'номер',
        'contract_num' => 'номер договора',
        'contractNum'  => 'номер договора',
        'client_id'    => 'клиент',
        'clientId'     => 'клиент',
        'clientName'   => 'клиент',
        'date'         => 'дата',
        'sum'          => 'сумма',
        'dateFrom'     => 'дата с',
        'dateTo'       => 'дата по',
        'payed'        => 'оплачено',
    ];

    /**
     * @var int
     */
    protected int $id;
    /**
     * @var string
     */
    protected string $number;
    /**
     * @var string
     */
    protected string $date = '';
    /**
     * @var float
     */
    protected ?float $sum = null;
    /**
     * @var float
     */
    protected float $payed;

    # Getters
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getSum(): ?float
    {
        return $this->sum;
    }

    /**
     * @return float
     */
    public function getPayed(): float
    {
        return $this->payed;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return [
            'number'       => $this->number,
            'client_id'    => $this->clientId,
            'contract_num' => $this->contractNum,
            'date'         => $this->date,
            'sum'          => $this->sum,
            'payed'        => $this->payed,
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
        $entity->number = $state['number'] ?? null;
        $entity->clientId = $state['client_id'] ?? null;
        $entity->contractNum = $state['contract_num'] ?? null;
        $entity->date = $state['date'] ?? null;
        $entity->sum = $state['sum'] ?? null;
        $entity->payed = $state['payed'] ?? null;
        return $entity;
    }

    /**
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'date, contract_num, client_id, number' => 'required',
            'number, client_id'                     => 'numerical',
        ];
    }

    # SETTERS

    public function setNumber($value = null): Invoice
    {
        return $this->_setAttribute('number', $value);
    }

    public function setContractNum($value = null): Invoice
    {
        return $this->_setAttribute('contractNum', $value);
    }

    public function setDate($value = null): Invoice
    {
        return $this->_setAttribute('date', $value);
    }

    public function setSum($value = null): Invoice
    {
        return $this->_setAttribute('sum', $value);
    }

    public function setPayed($value = null): Invoice
    {
        return $this->_setAttribute('payed', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setNumber($state['number'] ?? null)
            ->setClientId($state['client_id'] ?? null)
            ->setContractNum($state['contract_num'] ?? null)
            ->setDate($state['date'] ?? null)
            ->setSum($state['sum'] ?? null)
            ->setPayed($state['payed'] ?? null);
    }
}
