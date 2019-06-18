<?php
namespace app\interfaces;

interface BillRepositoryInterface extends RepositoryInterface
{
    /**
     * Список счетов отфильтрованных по дате контракта
     *
     * @param array $where условия поиска
     * @return array
     */
    public function getAllByContract($where=array()): array;

    /**
     * Список счетов отфильтрованных по номеру контракта
     * 
     * @param array $where условия поиска
     * @return integer
     */
    public function getTotalByContract($where=array()): int;
}
