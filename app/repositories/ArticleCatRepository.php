<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ArticleCat;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleCatRepository extends Repository
{
    /**
     * @var ArticleCat
     */
    protected $articleCat;

    public function __construct(ArticleCat $entity, ...$params)
    {
        $this->articleCat = $entity;

        parent::__construct(...$params);
    }
}
