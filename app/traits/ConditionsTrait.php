<?php

namespace app\traits;

use tachyon\db\dbal\conditions\Terms;
use tachyon\helpers\DateTimeHelper;

/**
 * @author imndsu@gmail.com
 */
trait ConditionsTrait
{
    /**
     * Sets the range of the first and last day of the year
     */
    public function setYearBorders(array $conditions = [], string $alias = null): array
    {
        $alias = $alias ?? $this->tableAlias;

        if (!isset($conditions['dateFrom'])) {
            $conditions['dateFrom'] = DateTimeHelper::getYearBorders()['first'];
        } elseif (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $conditions['dateFrom'])) {
            $conditions['dateFrom'] = \DateTime::createFromFormat('d.m.Y', $conditions['dateFrom'])->format('Y-m-d');
        }
        if (!isset($conditions['dateTo'])) {
            $conditions['dateTo'] = DateTimeHelper::getYearBorders()['last'];
        } elseif (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $conditions['dateTo'])) {
            $conditions['dateTo'] = \DateTime::createFromFormat('d.m.Y', $conditions['dateTo'])->format('Y-m-d');
        }
        $terms = app()->get(Terms::class);
        $where = array_merge(
            $terms->gt($conditions, "$alias.date", 'dateFrom'),
            $terms->lt($conditions, "$alias.date", 'dateTo')
        );
        unset($conditions['dateFrom'], $conditions['dateTo']);

        return array_merge($where, $conditions);
    }
}
