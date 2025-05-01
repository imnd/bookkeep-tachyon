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
        }
        if (!isset($conditions['dateTo'])) {
            $conditions['dateTo'] = DateTimeHelper::getYearBorders()['last'];
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
