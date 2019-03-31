<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class Bill extends Entity
{
    use \app\traits\Client;

    protected $attributeCaptions = [
        'contents' => 'содержание',
        'clientName' => 'клиент',
        'client_id' => 'клиент',
        'contractNum' => 'номер договора',
        'contract_num' => 'номер договора',
        'sum' => 'сумма',
        'remainder' => 'остаток',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $clientId;
    /**
     * @var string
     */
    protected $clientName;
    /**
     * @var string
     */
    protected $contractNum;
    /**
     * @var float
     */
    protected $sum;
    /**
     * @var float
     */
    protected $remainder;
    /**
     * @var string
     */
    protected $date;
    /**
     * @var string
     */
    protected $contents;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getContractNum()
    {
        return $this->contractNum;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getRemainder()
    {
        return $this->remainder;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getContentsReadable()
    {
        return [
            'payment' => 'платёж',
            'purchase' => 'закуп',
        ][$this->contents] ?? '';
    }

    public function getAttributes(): array
    {
        return [
            'client_id' => $this->clientId,
            'contract_num' => $this->contractNum,
            'sum' => $this->sum,
            'remainder' => $this->remainder,
            'date' => $this->date,
            'contents' => $this->contents,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->clientId = $state['client_id'] ?? null;
        $entity->clientName = $state['clientName'] ?? null;
        $entity->contractNum = $state['contract_num'] ?? null;
        $entity->sum = $state['sum'] ?? null;
        $entity->remainder = $state['remainder'] ?? null;
        $entity->date = $state['date'] ?? null;
        $entity->contents = $state['contents'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return [
            'contract_num' => ['integer', 'required'],
            'client_id' => ['integer', 'required'],
            'date' => ['required'],
        ];
    }

    # Setters

    public function setSum(int $value = null): Bill
    {
        return $this->_setAttribute('sum', $value);
    }

    public function setRemainder(int $value = null): Bill
    {
        return $this->_setAttribute('remainder', $value);
    }

    public function setDate($value = null): Bill
    {
        return $this->_setAttribute('date', $value);
    }

    public function setContents(int $value = null): Bill
    {
        return $this->_setAttribute('contents', $value);
    }

    public function setAttributes(array $state)
    {
        $this
            ->setClientId($state['client_id'] ?: null)
            ->setContractNum($state['contract_num'] ?: null)
            ->setSum($state['sum'] ?: null)
            ->setDate($state['date'] ?: null)
            ->setContents($state['contents'] ?: null)
        ;
    }
}
