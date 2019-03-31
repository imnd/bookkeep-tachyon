<?php
namespace app\models;

/**
 * Класс модели фактур
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Invoices extends \app\models\HasRowsModel
{
    use \tachyon\traits\DateTime,
        \app\traits\Client,
        \app\traits\Contract;

    protected static $tableName = 'invoices';
    protected $pkName = 'id';
    protected $fields = [
        'client_id',
        'number',
        'date',
        'contract_num',
        'sum',
        'payed',
    ];
    protected $fieldTypes = [
        'id' => 'int',
        'client_id' => 'smallint',
        'number' => 'tinytext',
        'date' => 'date',
        'contract_num' => 'tinytext',
        'sum' => 'float',
        'payed' => 'float',
    ];
    protected $attributeTypes = [
        'number' => 'input',
        'contract_num' => 'input',
        'client_id' => 'select',
        'date' => 'input',
        'dateFrom' => 'input',
        'dateTo' => 'input',
    ];
    protected $attributeNames = [
        'number' => 'номер',
        'contract_num' => 'номер договора',
        'client_id' => 'клиент',
        'client_name' => 'клиент',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'sum' => 'сумма',
        'payed' => 'оплачено',
    ];
    protected $scalarFields = array('number', 'contract_num');
    protected $entityNames = [
        'single' => 'фактура',
        'plural' => 'фактуры'
    ];
    protected $relations = [
        'client' => array('Clients', 'has_one', 'client_id'),
        'contract' => array('Contracts', 'has_one', array('contract_num', 'contract_num')),
    ];
    protected $rowFk = 'invoice_id';
    protected $rowModelName = 'InvoicesRows';
    protected $defSortBy = array('number' => 'DESC');

    public function rules(): array
    {
        return [
            'date, contract_num, client_id, name, number' => array('required'),
            'number, client_id' => array('numerical'),
            'name' => array('alphaExt'),
        ];
    }

    /**
     * @param array $conditions условия поиска
     * @return Invoices
     */
    public function setSearchConditions(array $conditions = array()): Invoices
    {
        $this->setYearBorders($conditions);
        parent::setSearchConditions($conditions);

        return $this;
    }

    /**
     * @param array $conditions условия поиска
     * @return array
     */
    public function findAllRaw(array $conditions=array()): array
    {
        $this
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->select([
                '*',
                'sum-payed' => 'balance',
                'cl.name' => 'client_name',
            ]);

        return parent::findAllRaw($conditions);
    }

    /**
     * Список фактур отфильтрованных по дате контракта
     *
     * @param array $conditions условия поиска
     * @returns array
     * @return array
     */
    public function getAllByContract($conditions=array()): array
    {
        $this
            ->select(array('date', 'number', 'sum'))
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($conditions, 'cn.date', 'dateFrom')
            ->lt($conditions, 'cn.date', 'dateTo')
        ;

        if (!empty($conditions['client_id']))
            $this->addWhere(array('cl.id' => $conditions['client_id']));
        if (!empty($conditions['contract_num']))
            $this->addWhere(array('cn.contract_num' => $conditions['contract_num']));
            
        return $this->findAllRaw();
    }

    /**
     * @param array $conditions условия поиска
     * @return integer
     */
    public function getTotalByContract($conditions=array()): int
    {
        $this
            ->asa('i')
            ->select('SUM(i.sum) as total')
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->join(array('contracts' => 'cn'), array('contract_num', 'contract_num'))
            ->gt($conditions, 'cn.date', 'dateFrom')
            ->lt($conditions, 'cn.date', 'dateTo')
        ;
            
        if (!empty($conditions['client_id'])) {
            $this->addWhere(array('cl.id' => $conditions['client_id']));
        }
        if (!empty($conditions['contract_num'])) {
            $this->addWhere(array('cn.contract_num' => $conditions['contract_num']));
        }
        $item = $this->findOneRaw();
        if ($value = $item['total']) {
            return $value;
        }
        return 0;
    }

    /**
     * Возвращает последний (максимальный) номер
     * @return integer
     */
    public function getLastNumber(): int
    {
        $item = $this
            ->select('number')
            ->limit(1)
            ->findOneRaw();

        return $item['number'];
    }
}
