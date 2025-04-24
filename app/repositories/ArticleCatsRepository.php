<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ArticleCat;

/**
 * @author imndsu@gmail.com
 */
class ArticleCatsRepository extends Repository
{
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
