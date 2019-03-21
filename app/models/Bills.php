<?php
namespace app\models;

use tachyon\behaviours\DateTime;

/**
 * Класс модели биллинга
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Bills extends \tachyon\db\activeRecord\ActiveRecord
{
    use \app\traits\DateTime,
        \app\traits\Client,
        \tachyon\traits\ListTrait;

    /**
     * Поле модели, которое попадает в подпись элемента селекта
     * @var $valueField string | array
     */
    protected $valueField = 'value';
    /**
     * В случае, если $valueField - массив это строка, склеивающая возвращаемые значения
     * @var $valsGlue string
     */
    protected $valsGlue = ' :: ';
    /**
     * Поле первичного ключа модели
     * @var $pkField integer
     */
    protected $pkField = 'id';
    /**
     * Пустое значение в начале списка для селекта. Равно false если выводить не надо.
     * @var $pkField integer | boolean
     */
    protected $emptyVal = '...';

    protected static $tableName = 'bills';
    protected $pkName = 'id';
    protected $fields = array('client_id', 'contract_num', 'sum', 'remainder', 'date', 'contents');
    protected $fieldTypes = [
        'id' => 'mediumint',
        'client_id' => 'smallint',
        'contract_num' => 'tinytext',
        'sum' => 'double',
        'remainder' => 'double',
        'date' => 'date',
        'contents' => 'tinytext',
    ];
    protected $attributeNames = [
        'client_id' => 'клиент',
        'clientName' => 'клиент',
        'contract_num' => 'номер договора',
        'sum' => 'сумма',
        'remainder' => 'остаток',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'contents' => 'содержание',
    ];
    protected $entityNames = [
        'single' => 'платеж',
        'plural' => 'платежи'
    ];

    /**
     * @var \tachyon\behaviours\DateTime $dateTime
     */
    protected $dateTime;

    public function __construct(DateTime $dateTime, ...$params)
    {
        $this->dateTime = $dateTime;

        parent::__construct(...$params);
    }

    public function rules(): array
    {
        return [
            'contract_num' => array('integer', 'required'),
            'client_id' => array('integer', 'required'),
            'date' => array('required'),
        ];
    }

    /**
     * @param array $conditions условия поиска
     */
    public function setSearchConditions(array $conditions=array()): Bills
    {
        $this->setYearBorders($conditions);
        parent::setSearchConditions($conditions);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function findAllScalar(array $conditions=array()): array
    {
        $this
            ->join(array('clients' => 'cl'), array('client_id', 'id'))
            ->select([
                '*',
                'cl.name' => 'clientName',
            ]);

        return parent::findAllScalar($conditions);
    }

    /**
     * Список счетов отфильтрованных по дате контракта
     *
     * @param array $conditions условия поиска
     * @returns array
     */
    public function getAllByContract($conditions=array()): array
    {
        $this
            ->select(array('date', 'sum'))
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
        return $this->findAllScalar();
    }

    /**
     * Список счетов отфильтрованных по номеру контракта
     * 
     * @param array $conditions условия поиска
     * @return integer
     */
    public function getTotalByContract($conditions=array()): int
    {
        $this
            ->asa('b')
            ->select('SUM(b.sum) as total')
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
        $item = $this->findOneScalar();
        
        if ($value = $item['total']) {
            return $value;
        }
        return 0;
    }

    /**
     * @return array
     */
    public function getContentsList(): array
    {
        return [
            'payment' => 'платёж',
            'purchase' => 'закуп',
        ];
    }
}
