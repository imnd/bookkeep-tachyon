<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Client,
    app\repositories\RegionRepository;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ClientRepository extends Repository
{
    protected $tableName = 'clients';

    /**
     * @var app\entities\Client
     */
    protected $client;
    /**
     * @var app\repositories\RegionRepository
     */
    protected $regionRepository;

    public function __construct(Client $client, RegionRepository $regionRepository, ...$params)
    {
        $this->client = $client;
        $this->regionRepository = $regionRepository;

        parent::__construct(...$params);
    }

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
