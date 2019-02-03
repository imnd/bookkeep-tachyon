<?php
namespace app\models;

/**
 * Класс модели договоров (приложений к договорам)
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Contracts extends \app\components\HasRowsModel
{
    use \tachyon\dic\behaviours\ListBehaviour;
    use \tachyon\dic\behaviours\DateTime;

    use \app\traits\ClientTrait;

    public static $tableName = 'contracts';
    protected $pkName = 'id';
    public static $fields = array('contract_num', 'client_id', 'sum', 'payed', 'date', 'term_start', 'term_end', 'type');

    protected $scalarFields = array('contract_num');
    protected $fieldTypes = array(
        'id' => 'mediumint',
        'client_id' => 'tinyint',
        'contract_num' => 'tinytext',
        'sum' => 'double',
        'payed' => 'double',
        'date' => 'date',
        'term_start' => 'date',
        'term_end' => 'date',
        'type' => 'enum',
    );
    protected $attributeTypes = array(
        'contract_num' => 'input',
        'client_id' => 'select',
        'date' => 'input',
        'dateFrom' => 'input',
        'dateTo' => 'input',
        'term_start' => 'input',
        'term_end' => 'input',
        'sum' => 'input',
        'payed' => 'input',
        'type' => 'select',
    );
    protected $attributeNames = array(
        'contract_num' => 'номер',
        'client_id' => 'клиент',
        'clientName' => 'клиент',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'term_start' => 'срок поставки от',
        'term_end' => 'срок поставки до',
        'sum' => 'сумма',
        'payed' => 'оплачено',
        'payedRemind' => 'осталось оплатить',
        'executed' => 'выбрано',
        'execRemind' => 'осталось выбрать',
        'type' => 'тип',
    );

    protected $relations = array(
        'client' => array('Clients', 'has_one', 'client_id'),
    );
    protected $rowFk = 'contract_id';
    protected $rowModelName = 'ContractsRows';
    protected $defSortBy = array('contract_num' => 'DESC');
    protected $entityNames = array(
        'single' => 'договор',
        'plural' => 'договоры'
    );

    /**
     * Названия типов
     * @var $_types array
     */
    private $_types = array(
        'contract' => 'контракт',
        'agreement' => 'договор',
    );

    public function rules(): array
    {
        return array(
            'contract_num' => array('integer', 'required'),
            'client_id' => array('integer', 'required'),
            'date' => array('required'),
            'term_start' => array('required'),
            'term_end' => array('required'),
//            'type' => array('in' => array_keys($this->_types)), // TODO: сделать
        );
    }
    
    /**
     * @param array $conditions условия поиска
     */
    public function setSearchConditions(array $where=array()): Contracts
    {
        \tachyon\helpers\DateTimeHelper::setYearBorders($this, $where);
        return $this;
    }

    /**
     * getTypeName
     * Название типа
     * 
     * @return string
     */
    public function getTypeName($type=null, $case='nom'): string
    {
        if (is_null($type))
            $type = $this->type;

        if ($case==='gen')
            $this->_types = array_map(
                function($key, $val) {
                    return $val . 'ов';
                },
                array_keys($this->_types),
                array_values($this->_types)
            );

        return $this->_types[$type] ?? implode(' и ', $this->_types);
    }

    /**
     * Список типов для селекта на форме
     * 
     * @return array
     */
    public function getTypes(): array
    {
        return $this->listBehaviour->getSelectListFromArr($this->_types, true);
    }

    /**
     * @param array $conditions условия поиска
     * @return array
     */
    public function findAllScalar(array $conditions=array()): array
    {
        $list = array();
        $this
            ->asa('t')
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('invoices' => 'i'), array('contract_num', 'contract_num'))
            ->select(array(
                '*',
                'cl.name' => 'clientName',
                'cl.address' => 'clientAddr',
                'SUM(i.sum)' => 'executed',
                't.sum - SUM(i.sum)' => 'execRemind',
            ))
            ->groupBy('t.contract_num');
        
        $listExecuted = parent::findAllScalar($conditions);

        $this
            ->asa('t')
            ->join(array('billing' => 'b'), array('contract_num', 'contract_num'))
            ->select(array(
                'SUM(b.sum)' => 'payed',
            ))
            ->groupBy('t.contract_num');

        $listPayed = parent::findAllScalar(array_merge($conditions, array('b.contents' => 'payment')));

        foreach ($listExecuted as $key => $contract) {
            $payed = !empty($listPayed[$key]['payed']) ? $listPayed[$key]['payed'] : 0;
            $contract['payed'] = $payed;
            $contract['payedRemind'] = round($contract['executed'] - $payed, 2);
            $list[] = $contract;
        }

        return $list;
    }
    
    /**
     * @param array $conditions условия поиска
     * @return array
     */
    public function getItem($conditions=array()): array
    {
        $item = $this->findOneScalar($conditions);
        $item['rows'] = $this->get('ContractsRows')
            ->addWhere(array(
                'contract_id' => $item['id'],
            ))
            ->findAllScalar();

        return $item;
    }
    
    /**
     * @param array $conditions условия поиска
     * @return array
     */
    public function getNumbers($conditions=array()): array
    {
        $items = $this
            ->select('contract_num')
            ->findAllScalar($conditions);

        return $this->listBehaviour->getValsList($items, 'contract_num');
    }
}
