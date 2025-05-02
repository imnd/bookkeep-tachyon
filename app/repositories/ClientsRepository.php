<?php
namespace app\repositories;

use
    app\entities\Client,
    tachyon\db\dataMapper\Repository,
    tachyon\db\dbal\conditions\Terms
;

/**
 * @author imndsu@gmail.com
 */
class ClientsRepository extends Repository
{
    protected string $tableName = 'clients';

    public function __construct(
        protected Terms $terms,
        Client $client,
        ...$params
    ) {
        $this->entity = $client;

        parent::__construct(...$params);
    }

    public function setSearchConditions(array $conditions = []): Repository
    {
        foreach (['name', 'address'] as $field) {
            if (!empty($where = $this->terms->like($conditions, $field))) {
                $conditions = array_merge(
                    $conditions,
                    $where
                );
            }
        }
        parent::setSearchConditions($conditions);

        return $this;
    }
}
