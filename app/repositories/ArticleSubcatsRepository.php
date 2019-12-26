<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ArticleSubcat;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleSubcatsRepository extends Repository
{
    /**
     * @var app\entities\ArticleSubcat
     */
    protected $articleSubcat;

    public function __construct(ArticleSubcat $entity, ...$params)
    {
        $this->articleSubcat = $entity;

        parent::__construct(...$params);
    }
}
