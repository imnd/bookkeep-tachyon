<?php
namespace app\repositories;

use \tachyon\db\dataMapper\Repository;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ClientRepository extends Repository
{
    use \app\dic\Client;
    use \app\dic\RegionRepository;

    protected $tableName = 'clients';

    /**
     * @param array $conditions условия поиска
     */
    public function setSearchConditions($conditions=array()): Repository
    {
        foreach (['name', 'address'] as $field) {
            if (!empty($where = $this->terms->like($conditions, $field))) {
                $this->where = array_merge(
                    $this->where,
                    $where
                );
            }
        }
        parent::setSearchConditions($conditions);

        return $this;
    }
}
