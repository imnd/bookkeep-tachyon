<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\Region;

/**
 * @author imndsu@gmail.com
 */
class RegionsRepository extends Repository
{
    /**
     * @param Region $region
     * @param array $params
     */
    protected string $tableName = 'regions';

    public function __construct(Region $region, ...$params)
    {
        $this->entity = $region;

        parent::__construct(...$params);
    }
}
