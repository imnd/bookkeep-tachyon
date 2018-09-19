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
    public static $primKey = 'id';
    public static $fields = array('contract_num', 'client_id', 'sum', 'payed', 'date', 'term_start', 'term_end', 'type');

    protected $scalarFields = array('contract_num');
    protected static $fieldTypes = array(
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
    protected static $attributeTypes = array(
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
    protected static $attributeNames = array(
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

    public function rules()
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
    
    public function setSearchConditions($where=array())
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
    public function getTypeName($type=null, $case='nom')
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

        if (isset($this->_types[$type]))
            return $this->_types[$type];
        else
            return implode(' и ', $this->_types);
    }

    /**
     * Список типов для селекта на форме
     * 
     * @return array
     */
    public function getTypes()
    {
        return $this->listBehaviour->getSelectListFromArr($this->_types, true);
    }

    public function getAllByConditions($where=array())
    {
        $list = array();
        $listExecuted = $this
            ->asa('t')
            ->addWhere($where)
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('invoices' => 'i'), array('contract_num', 'contract_num'))
            ->select(array(
                '*',
                'cl.name' => 'clientName',
                'cl.address' => 'clientAddr',
                'SUM(i.sum)' => 'executed',
                't.sum - SUM(i.sum)' => 'execRemind',
            ))
            ->groupBy('t.contract_num')
            ->getAll();

        $listPayed = $this
            ->asa('t')
            ->addWhere(array_merge($where, array('b.contents' => 'payment')))
            ->join(array('billing' => 'b'), array('contract_num', 'contract_num'))
            ->select(array(
                'SUM(b.sum)' => 'payed',
            ))
            ->groupBy('t.contract_num')
            ->getAll();

        foreach ($listExecuted as $key => $contract) {
            $payed = !empty($listPayed[$key]['payed']) ? $listPayed[$key]['payed'] : 0;
            $contract['payed'] = $payed;
            $contract['payedRemind'] = round($contract['executed'] - $payed, 2);
            $list[] = $contract;
        }

        return $list;
    }
    
    public function getItem($where=array())
    {
        $item = $this
            ->addWhere($where)
            ->getOne();
            
        $item['rows'] = $this->get('ContractsRows')
            ->addWhere(array(
                'contract_id' => $item['id'],
            ))
            ->getAll();

        return $item;
    }
    
    /**
     * getNumbers
     * 
     * @param $where array 
     * @return array
     */
    public function getNumbers($where=array())
    {
        $items = $this
            ->addWhere($where)
            ->select('contract_num')
            ->getAll();

        return $this->listBehaviour->getValsList($items, 'contract_num');
    }
}
