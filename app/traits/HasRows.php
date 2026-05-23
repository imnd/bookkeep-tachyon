<?php

namespace app\traits;

/**
 * @author imndsu@gmail.com
 */
trait HasRows
{
    private array $rows = [];

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows($rows = []): void
    {
        foreach ($rows as $row) {
            $this->rows[] = $row;
        }
    }

    public function getQuantitySum(): int
    {
        $result = 0;
        foreach ($this->rows as $row) {
            $result += $row->getQuantity();
        }
        return $result;
    }

    public function getPriceSum(): int
    {
        $result = 0;
        foreach ($this->rows as $row) {
            $result += $row->getPrice();
        }
        return $result;
    }

    public function deleteRows(): void
    {
        foreach ($this->rows as $row) {
            $row->markDeleted();
        }
    }
}
