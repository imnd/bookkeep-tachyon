<?php
namespace app\repositories;

use app\traits\ConditionsTrait;
use tachyon\db\dataMapper\Repository,
    app\entities\ArticleCat;

/**
 * @author imndsu@gmail.com
 */
class ArticleCatsRepository extends Repository
{
    use ConditionsTrait;

    /**
     * @param ArticleCat $articleCat
     * @param array $params
     */
    public function __construct(ArticleCat $articleCat, ...$params)
    {
        $this->entity = $articleCat;

        parent::__construct(...$params);
    }
}
