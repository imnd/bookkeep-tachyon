<?php
namespace app\repositories;

use app\traits\ConditionsTrait,
    app\entities\ArticleCat,
    tachyon\db\dataMapper\Repository;

/**
 * @author imndsu@gmail.com
 */
class ArticleCatsRepository extends Repository
{
    use ConditionsTrait;

    public function __construct(ArticleCat $articleCat, ...$params)
    {
        $this->entity = $articleCat;

        parent::__construct(...$params);
    }
}
