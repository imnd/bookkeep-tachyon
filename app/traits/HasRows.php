<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
trait HasRows
{
    /**
     * @var array строки
     */
    private $rows = [];

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows = array())
    {
        foreach ($rows as $row) {
            $this->rows[] = $row;
        }
    }

    /**
     * @return integer
     */
    public function getQuantitySum()
    {
        $result = 0;
        foreach ($this->rows as $row) {
            $result += $row->getQuantity();
        }
        return $result;
    }

    /**
     * @return integer
     */
    public function getPriceSum()
    {
        $result = 0;
        foreach ($this->rows as $row) {
            $result += $row->getPrice();
        }
        return $result;
    }
}
