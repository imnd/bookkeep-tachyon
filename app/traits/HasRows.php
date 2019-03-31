<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */ 
trait HasRows
{
    /**
     * @var RowEntity[] строки
     */
    private $rows;

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
}
