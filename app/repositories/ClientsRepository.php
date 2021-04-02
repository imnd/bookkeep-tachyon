<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Client,
    tachyon\traits\RepositoryListTrait;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ClientsRepository extends Repository
{
    use RepositoryListTrait;

    protected string $tableName = 'clients';

    /**
     * @param Client $client
     * @param array $params
     */
    public function __construct(Client $client, ...$params)
    {
        $this->entity = $client;

        parent::__construct(...$params);
    }

    /**
     * @param array $conditions условия поиска
     * @return ClientsRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        foreach (['name', 'address'] as $field) {
            if (!empty($where = $this->like($conditions, $field))) {
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
