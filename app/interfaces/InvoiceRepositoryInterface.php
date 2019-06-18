<?php
namespace app\interfaces;

interface InvoiceRepositoryInterface extends RepositoryInterface
{
    /**
     * Список фактур отфильтрованных по дате контракта
     *
     * @param array $where условия поиска
     * @returns array
     * @return array
     */
    public function getAllByContract($where = array()): array;

    /**
     * @param array $where условия поиска
     * @return integer
     */
    public function getTotalByContract($where = array()): int;
}
