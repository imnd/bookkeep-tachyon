<?php

namespace app\traits;

/**
 * @author imndsu@gmail.com
 */
trait Select
{
    /**
     * Список для дроп-дауна по условию $where, отсортированных по $sort
     *
     * @param string $valueField
     * @param array  $where
     * @param array  $sort
     *
     * @return array
     */
    public function getSelectList(
        string $valueField = 'name',
        array  $where = [],
        array  $sort = []
    ): array
    {
        $items = $this->findAll($where, $sort);
        $getter = 'get' . ucfirst($valueField);
        $ret = [
            [
                'id' => '',
                'value' => '...',
            ],
        ];
        foreach ($items as $item) {
            $ret[] = [
                'id' => $item->getId(),
                'value' => $item->$getter(),
            ];
        }
        return $ret;
    }
}
