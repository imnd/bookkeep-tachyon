<?php
namespace app\models;

/**
 * Класс модели закупок
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Purchases extends \app\components\HasRowsModel
{
    use \tachyon\dic\behaviours\DateTime;

    use \app\traits\ClientTrait;

    public static $tableName = 'purchases';
    public static $primKey = 'id';
    public static $fields = array('number', 'date', 'sum');

    protected static $fieldTypes = array(
        'number' => 'tinytext',
        'date' => 'date',
        'sum' => 'double',
    );
    protected static $attributeNames = array(
        'number' => 'номер',
        'date' => 'дата',
        'dateFrom' => 'дата с',
        'dateTo' => 'дата по',
        'sum' => 'сумма',
    );
    protected $entityNames = array(
        'single' => 'закупка',
        'plural' => 'закупки'
    );
    protected $rowFk = 'purchase_id';
    protected $rowModelName = 'PurchasesRows';

    public function rules()
    {
        return array(
            'date, sum, number' => array('required'),
            'number' => array('numerical', 'unique'),
        );
    }

    public function setSearchConditions($where=array())
    {
        \tachyon\helpers\DateTimeHelper::setYearBorders($this, $where);
        return $this;
    }

    /**
     * getReport
     * Собираем закупку
     *
     * @param string $dateFrom
     * @param string $dateTo
     *
     * @returns array
     */
    public function getReport($dateFrom=null, $dateTo=null)
    {
        if (is_null($dateTo))
            $dateTo = $dateFrom;

        return $this->db->queryAll("
            SELECT
                  ROUND(SUM(sup.quantity), 1) AS quantity
                , MIN(sup.price) AS min_price
                , MAX(sup.price) AS max_price
                , SUM(sup.price * sup.quantity) / SUM(sup.quantity) AS average_price
                , artsub.name AS article_subcat
                , artsub.id AS article_subcat_id
                , GROUP_CONCAT(i.number) AS inv_numbers
            FROM `" . \app\models\Invoices::getTableName() . "` i
            LEFT JOIN `" . \app\models\InvoicesRows::getTableName() . "` sup
                ON sup.invoice_id=i.id
            LEFT JOIN `" . \app\models\Articles::getTableName() . "` art
                ON art.id=sup.article_id
            LEFT JOIN `" . \app\models\ArticleSubcats::getTableName(). "` artsub
                ON artsub.id=art.subcat_id
            " . (!is_null($dateFrom) ? "WHERE i.date>='$dateFrom' AND i.date<='$dateTo'" : '') . "
            GROUP BY artsub.id 
        ");
    }
}
