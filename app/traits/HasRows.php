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
    private array $rows = [];

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows($rows = array()): void
    {
        foreach ($rows as $row) {
            $this->rows[] = $row;
        }
    }

    /**
     * @return integer
     */
    public function getQuantitySum(): int
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
    public function getPriceSum(): int
    {
        $result = 0;
        foreach ($this->rows as $row) {
            $result += $row->getPrice();
        }
        return $result;
    }
}
