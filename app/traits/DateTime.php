<?php
namespace app\traits;

/**
 * Трейт аутентификации
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait DateTime
{
    /**
     * Возвращает первый и последний день года.
     * 
     * @return array
     */
    public function getYearBorders()
    {
        $curYear = date('Y');
        return [
            'first' => "$curYear-01-01",
            'last' =>"$curYear-12-31",
        ];
    }

    /**
     * Устанавливает диапазон первый и последний день года.
     * 
     * @param array $conditions
     * @return void
     */
    public function setYearBorders(array $conditions = array())
    {
        if (!isset($conditions['dateFrom'])) {
            $conditions['dateFrom'] = $this->getYearBorders()['first'];
        }
        $this->gt($conditions, 'date', 'dateFrom');

        if (!isset($conditions['dateTo'])) {
            $conditions['dateTo'] = $this->getYearBorders()['last'];
        }
        $this->lt($conditions, 'date', 'dateTo');
    }

}
