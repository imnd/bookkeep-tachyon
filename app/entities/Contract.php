<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity,
    tachyon\traits\DateTime,
    app\traits\HasRows,
    app\traits\HasClient;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Contract extends Entity
{
    use HasClient,
        HasRows,
        DateTime;

    protected $attributeCaptions = [
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
     * @var $_types array
     */
    protected $_types = [
        'contract' => 'контракт',
        'agreement' => 'договор',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $contractNum;
    /**
     * @var string
     */
    protected $date;
    /**
     * @var string
     */
    protected $termStart;
    /**
     * @var string
     */
    protected $termEnd;
    /**
     * @var float
     */
    protected $sum;
    /**
     * @var float
     */
    protected $executed;
    /**
     * @var float
     */
    protected $execRemind;
    /**
     * @var float
     */
    protected $payed;
    /**
     * @var float
     */
    protected $payedRemind;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getContractNum()
    {
        return $this->contractNum;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getExecuted()
    {
        return $this->executed;
    }

    public function getExecRemind()
    {
        return $this->execRemind;
    }

    public function getPayed()
    {
        return $this->payed;
    }

    public function getPayedRemind()
    {
        return $this->payedRemind;
    }

    public function getTermStart()
    {
        return $this->termStart;
    }

    public function getTermEnd()
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
            'contractNum' => array('integer', 'required'),
            'clientId' => array('integer', 'required'),
            'date' => array('required'),
            'termStart' => array('required'),
            'termEnd' => array('required'),
//            'type' => array('in' => array_keys($this->_types)), // TODO: сделать
        ];
    }

    /**
     * Название типа
     *
     * @param null $type
     * @param string $case
     * @return string
     */
    public function getTypeName($type=null, $case='nom'): string
    {
        if ($case==='gen') {
            $this->_types = array_map(
                function($val) {
                    return $val . 'ов';
                },
                array_values($this->_types)
            );
        }
        if (is_null($type)) {
            $type = $this->type;
        }
        return $this->_types[$type] ?? implode(' и ', $this->_types);
    }

    /**
     * Список типов для селекта на форме
     * 
     * @return array
     */
    public function getTypes(): array
    {
        return $this->getSelectListFromArr($this->_types, true);
    }

    # Setters

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

    public function setAttributes(array $state)
    {
        $this
            ->setClientId($state['client_id'] ?? null)
            ->setContractNum($state['contract_num'] ?? null)
            ->setDate($state['date'] ?? null)
            ->setSum($state['sum'] ?? null)
            ->setExecuted($state['executed'] ?? null)
            ->setExecRemind($state['execRemind'] ?? null)
            ->setPayed($state['payed'] ?? null)
            ->setPayedRemind($state['payedRemind'] ?? null)
            ->setTermStart($state['term_start'] ?? null)
            ->setTermEnd($state['term_end'] ?? null)
        ;
    }
}
