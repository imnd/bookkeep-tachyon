<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Region;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class RegionRepository extends Repository
{
    /**
     * @inheritdoc
     */
    protected $tableName = 'regions';
    /**
     * @var app\entities\Region
     */
    protected $region;

    public function __construct(Region $region, ...$params)
    {
        $this->region = $region;

        parent::__construct(...$params);
    }
}
