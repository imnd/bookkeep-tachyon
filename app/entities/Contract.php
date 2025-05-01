<?php

namespace app\entities;

use tachyon\db\dataMapper\Entity,
    app\interfaces\HasRowsInterface,
    app\traits\HasRows,
    app\traits\HasClient;

/**
 * Класс сущности "Контракт"
 *
 * @author imndsu@gmail.com
 */
class Contract extends Entity implements HasRowsInterface
{
    use HasClient,
        HasRows;

    protected array $attributeCaptions = [
        'contract_num' => 'номер',
        'client_id' => 'клиент',
        'clientName' => 'клиент',
        'contractNum' => 'номер договора',
        'sum' => 'сумма',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'termStart' => 'срок поставки от',
        'termEnd' => 'срок поставки до',
        'executed' => 'выбрано',
        'execRemind' => 'осталось выбрать',
        'payed' => 'оплачено',
        'payedRemind' => 'осталось оплатить',
        'type' => 'тип',
    ];

    /**
     * Названия типов
     */
    public const TYPES = [
        'contract' => 'контракт',
        'agreement' => 'договор',
    ];

    protected ?int $id = null;
    protected ?string $type = null;
    protected ?string $contractNum = null;
    protected ?string $date = null;
    protected ?string $termStart = null;
    protected ?string $termEnd = null;
    protected ?float $sum = null;
    protected ?float $executed = null;
    protected ?float $execRemind = null;
    protected ?float $payed = null;
    protected ?float $payedRemind = null;

    # region Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getContractNum(): ?string
    {
        return $this->contractNum;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function getExecuted(): ?float
    {
        return $this->executed;
    }

    public function getExecRemind(): ?float
    {
        return $this->execRemind;
    }

    public function getPayed(): ?float
    {
        return $this->payed;
    }

    public function getPayedRemind(): ?float
    {
        return $this->payedRemind;
    }

    public function getTermStart(): ?string
    {
        return $this->termStart;
    }

    public function getTermEnd(): ?string
    {
        return $this->termEnd;
    }

    public function getAttributes(): array
    {
        return [
            'client_id' => $this->clientId,
            'contract_num' => $this->contractNum,
            'date' => $this->date,
            'sum' => $this->sum,
            'payed' => $this->payed,
            'term_start' => $this->termStart,
            'term_end' => $this->termEnd,
            'type' => $this->type,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);
        $entity->id = $state['id'];
        $entity->clientName = $state['clientName'] ?? null;
        $entity->contractNum = $state['contract_num'] ?? null;
        $entity->clientId = $state['client_id'] ?? null;
        $entity->date = $state['date'] ?? null;
        $entity->termStart = $state['term_start'] ?? null;
        $entity->termEnd = $state['term_end'] ?? null;
        $entity->sum = $state['sum'] ?? null;
        $entity->payed = $state['payed'] ?? 0;
        $entity->type = $state['type'] ?? null;
        $entity->executed = $state['executed'] ?? null;
        $entity->execRemind = $state['execRemind'] ?? null;
        $entity->payedRemind = $state['payedRemind'] ?? null;
        return $entity;
    }

    public function rules(): array
    {
        return [
            'termStart, termEnd, contract_num, contractNum, clientId, client_id' => ['required', 'integer'],
            'type' => ['required', 'in:' . implode(',', array_keys(self::TYPES))],
        ];
    }

    /**
     * Название типа
     */
    public function getTypeName(string $type = null, string $case = 'nom'): string
    {
        if ($case === 'gen') {
            $types = array_map(
                static fn($val) => $val . 'ов',
                array_values(self::TYPES)
            );
        } else {
            $types = self::TYPES;
        }
        if (is_null($type)) {
            $type = $this->type;
        }
        return $types[$type] ?? implode(' и ', $types);
    }

    # endregion

    # region Setters

    public function setType($value = null): Contract
    {
        return $this->_setAttribute('type', $value);
    }

    public function setContractNum($value = null): Contract
    {
        return $this->_setAttribute('contractNum', $value);
    }

    public function setDate($value = null): Contract
    {
        return $this->_setAttribute('date', $value);
    }

    public function setSum(float $value = null): Contract
    {
        return $this->_setAttribute('sum', $value);
    }

    public function setExecuted(float $value = null): Contract
    {
        return $this->_setAttribute('executed', $value);
    }

    public function setExecRemind(float $value = null): Contract
    {
        return $this->_setAttribute('execRemind', $value);
    }

    public function setPayed(float $value = null): Contract
    {
        return $this->_setAttribute('payed', $value);
    }

    public function setPayedRemind(float $value = null): Contract
    {
        return $this->_setAttribute('payedRemind', $value);
    }

    public function setTermStart(string $value = null): Contract
    {
        return $this->_setAttribute('term_start', $value);
    }

    public function setTermEnd(string $value = null): Contract
    {
        return $this->_setAttribute('term_end', $value);
    }

    public function setAttributes(array $state): void
    {
        $this
            ->setClientId($state['client_id'] ?? null)
            ->setContractNum($state['contract_num'] ?? null)
            ->setDate($state['date'] ?? null)
            ->setSum($state['sum'] ?? null)
            ->setType($state['type'] ?? null)
            ->setExecuted($state['executed'] ?? null)
            ->setExecRemind($state['execRemind'] ?? null)
            ->setPayed($state['payed'] ?? null)
            ->setPayedRemind($state['payedRemind'] ?? null)
            ->setTermStart($state['term_start'] ?? null)
            ->setTermEnd($state['term_end'] ?? null);
    }

    # endregion
}
