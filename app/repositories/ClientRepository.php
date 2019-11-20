<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Client;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ClientRepository extends Repository
{
    use \app\traits\Select;

    protected $tableName = 'clients';
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client, ...$params)
    {
        $this->client = $client;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return ClientRepository
     */
    public function setSearchConditions($conditions = array()): Repository
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
