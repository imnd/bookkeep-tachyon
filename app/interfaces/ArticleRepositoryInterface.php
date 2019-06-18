<?php
namespace app\interfaces;

interface ArticleRepositoryInterface extends RepositoryInterface
{
    /**
     * Список для дроп-дауна по условию $where, отсортированных по $sort
     * 
     * @param string $valueField
     * @param array $where
     * @param array $sort
     * @return array
     */
    public function getSelectList(string $valueField = 'name', array $where = array(), array $sort = array());
}
