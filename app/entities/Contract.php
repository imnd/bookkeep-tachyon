<?php

namespace app\entities;

use tachyon\db\dataMapper\Entity,
    tachyon\traits\DateTime,
    app\interfaces\HasRowsInterface,
    app\traits\HasRows,
    app\traits\HasClient;

/**
 * Класс сущности "Клиент"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Contract extends Entity implements HasRowsInterface
{
    use HasClient,
        HasRows,
        DateTime;

    /**
     * @inheritdoc
     */
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
     *
     * @var $_types array
     */
    public const TYPES = [
        'contract' => 'контракт',
        'agreement' => 'договор',
    ];

    /**
     * @var int | null
     */
    protected ?int $id = null;
    /**
     * @var string | null
     */
    protected ?string $type = null;
    /**
     * @var string | null
     */
    protected ?string $contractNum = null;
    /**
     * @var string | null
     */
    protected ?string $date = null;
    /**
     * @var string | null
     */
    protected ?string $termStart = null;
    /**
     * @var string | null
     */
    protected ?string $termEnd = null;
    /**
     * @var float | null
     */
    protected ?float $sum = null;
    /**
     * @var float | null
     */
    protected ?float $executed = null;
    /**
     * @var float | null
     */
    protected ?float $execRemind = null;
    /**
     * @var float | null
     */
    protected ?float $payed = null;
    /**
     * @var float | null
     */
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
            'contractNum' => ['required', 'integer'],
            'clientId' => ['required', 'integer'],
            'termStart' => 'required',
            'termEnd' => 'required',
            'type' => ['required', 'in:' . implode(',', array_keys(self::TYPES))],
        ];
    }

    /**
     * Название типа
     *
     * @param null   $type
     * @param string $case
     *
     * @return string
     */
    public function getTypeName($type = null, $case = 'nom'): string
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

    public function setExecuted(double $value = null): Contract
    {
        return $this->_setAttribute('executed', $value);
    }

    public function setExecRemind(double $value = null): Contract
    {
        return $this->_setAttribute('execRemind', $value);
    }

    public function setPayed(double $value = null): Contract
    {
        return $this->_setAttribute('payed', $value);
    }

    public function setPayedRemind(double $value = null): Contract
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
