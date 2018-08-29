<?php
namespace app\models;

/**
 * Класс модели фактур
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Invoices extends \app\components\HasRowsModel
{
    use \tachyon\dic\behaviours\DateTime;

    use \app\traits\ClientTrait;
    use \app\traits\ContractTrait;

    public static $tableName = 'invoices';
    public static $primKey = 'id';
    public static $fields = array(
        'client_id',
        'number',
        'date',
        'contract_num',
        'sum',
        'payed',
    );

    protected static $fieldTypes = array(
        'id' => 'int',
        'client_id' => 'smallint',
        'number' => 'tinytext',
        'date' => 'date',
        'contract_num' => 'tinytext',
        'sum' => 'float',
        'payed' => 'float',
    );
    protected static $attributeTypes = array(
        'number' => 'input',
        'contract_num' => 'input',
        'client_id' => 'select',
        'date' => 'input',
        'dateFrom' => 'input',
        'dateTo' => 'input',
    );
    protected static $attributeNames = array(
        'number' => 'номер',
        'contract_num' => 'номер договора',
        'client_id' => 'клиент',
        'clientName' => 'клиент',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'sum' => 'сумма',
        'payed' => 'оплачено',
    );
    protected $scalarFields = array('number', 'contract_num');
    protected $entityNames = array(
        'single' => 'фактура',
        'plural' => 'фактуры'
    );
    protected $relations = array(
        'client' => array('Clients', 'has_one', 'client_id'),
        'contract' => array('Contracts', 'has_one', array('contract_num', 'contract_num')),
    );
    protected $rowFk = 'invoice_id';
    protected $rowModelName = 'InvoicesRows';
    protected $defSortBy = array('number' => 'DESC');

    public function rules()
    {
        return array(
            'date, contract_num, client_id, name, number' => array('required'),
            'number, client_id' => array('numerical'),
            'name' => array('alphaExt'),
        );
    }

    public function setSearchConditions($where = array())
    {
        \tachyon\helpers\DateTimeHelper::setYearBorders($this, $where);
        return $this;
    }

    public function getAllByConditions($where=array())
    {
        return $this
            ->addWhere($where)
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->select(array(
                '*',
                'sum-payed' => 'balance',
                'cl.name' => 'clientName',
            ))
            ->getAll();
    }

    /**
     * Список фактур отфильтрованных по дате контракта
     * 
     * @param array $where условия поиска
     * @returns array
     */
    public function getAllByContract($where=array())
    {
        $this
            ->select(array('date', 'number', 'sum'))
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo')
        ;

        if (!empty($where['client_id']))
            $this->addWhere(array('cl.id' => $where['client_id']));
        if (!empty($where['contract_num']))
            $this->addWhere(array('cn.contract_num' => $where['contract_num']));
            
        return $this->getAll();
    }

    /**
     * getTotalByContract
     * 
     * @param array $where условия поиска
     * 
     * @return integer
     */
    public function getTotalByContract($where=array())
    {
        $this
            ->asa('i')
            ->select('SUM(i.sum) as total')
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($where, 'cn.date', 'dateFrom')
            ->lt($where, 'cn.date', 'dateTo')
        ;
            
        if (!empty($where['client_id']))
            $this->addWhere(array('cl.id' => $where['client_id']));

        if (!empty($where['contract_num']))
            $this->addWhere(array('cn.contract_num' => $where['contract_num']));

        $item = $this->getOne();
        if ($value = $item['total'])
            return $value;
            
        return 0;
    }
    
    /**
     * getLastNumber
     * Возвращает последний (максимальный) номер
     * @return integer
     */
    public function getLastNumber()
    {
        $item = $this
            ->setSearchConditions()
            ->select('number')
            ->limit(1)
            ->getOne();

        return $item['number'];
    }
}
