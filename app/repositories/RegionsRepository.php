<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Region;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class RegionsRepository extends Repository
{
    /**
     * @param Region $region
     * @param array $params
     */
    public function __construct(Region $region, ...$params)
    {
        $this->entity = $region;

        parent::__construct(...$params);
    }
}
