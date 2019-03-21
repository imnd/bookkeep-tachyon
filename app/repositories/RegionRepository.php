<?php
namespace app\repositories;

use app\entities\Region;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class RegionRepository extends \tachyon\db\dataMapper\Repository
{
    /**
     * @var app\entities\Region
     */
    protected $region;

    public function __construct(Region $region, ...$params)
    {
        $this->region = $region;

        parent::__construct(...$params);
    }

    protected $tableName = 'regions';
}
