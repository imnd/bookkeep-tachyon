<?php
namespace app\repositories;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ClientRepository extends \tachyon\db\dataMapper\Repository
{
    use \app\dic\Client;
    use \app\dic\RegionRepository;

    protected $tableName = 'clients';
}
