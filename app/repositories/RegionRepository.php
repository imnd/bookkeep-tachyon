<?php
namespace app\repositories;

use app\entities\Region;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class RegionRepository extends \tachyon\db\dataMapper\Repository
{
    use \app\dic\Region;

    protected $tableName = 'regions';
}
