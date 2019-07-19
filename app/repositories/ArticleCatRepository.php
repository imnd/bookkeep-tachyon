<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\interfaces\ArticleCatRepositoryInterface,
    app\entities\ArticleCat;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleCatRepository extends Repository implements ArticleCatRepositoryInterface
{
    /**
     * @var app\entities\ArticleCat
     */
    protected $articleCat;

    public function __construct(ArticleCat $entity, ...$params)
    {
        $this->articleCat = $entity;

        parent::__construct(...$params);
    }
}
