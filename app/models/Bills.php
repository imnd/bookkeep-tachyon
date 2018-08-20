<?php
namespace app\models;

/**
 * Класс модели биллинга
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Bills extends \tachyon\db\models\ArModel
{
    use \tachyon\dic\behaviours\ListBehaviour;
    use \tachyon\dic\behaviours\DateTime;

    use \app\traits\ClientTrait;

    public static $primKey = 'id';
    public static $tableName = 'bills';
    public static $fields = array('client_id', 'contract_num', 'sum', 'remainder', 'date', 'contents');

    protected static $fieldTypes = array(
        'id' => 'mediumint',
        'client_id' => 'smallint',
        'contract_num' => 'tinytext',
        'sum' => 'double',
        'remainder' => 'double',
        'date' => 'date',
        'contents' => 'tinytext',
    );
    protected static $attributeNames = array(
        'client_id' => 'клиент',
        'clientName' => 'клиент',
        'contract_num' => 'номер договора',
        'sum' => 'сумма',
        'remainder' => 'остаток',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'contents' => 'содержание',
    );

    protected $entityNames = array(
        'single' => 'платеж',
        'plural' => 'платежи'
    );

    public function rules()
    {
        return array(
            'contract_num' => array('integer', 'required'),
            'client_id' => array('integer', 'required'),
            'date' => array('required'),
        );
    }

    public function setSearchConditions($where=array())
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
                'cl.name' => 'clientName',
            ))
            ->getAll();
    }

    /**
     * Список счетов отфильтрованных по дате контракта
     *
     * @param array $where условия поиска
     * @returns array
     */
    public function getAllByContract($where=array())
    {
        $this
            ->select(array('date', 'sum'))
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
     * Список счетов отфильтрованных по номеру контракта
     * 
     * @param array $where условия поиска
     * @return integer
     */
    public function getTotalByContract($where=array())
    {
        $this
            ->asa('b')
            ->select('SUM(b.sum) as total')
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
     * @return array
     */
    public function getContentsList()
    {
        return array(
            'payment' => 'платёж',
            'purchase' => 'закуп',
        );
    }
}
