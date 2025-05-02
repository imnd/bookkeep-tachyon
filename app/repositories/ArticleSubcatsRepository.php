<?php
namespace app\repositories;

use tachyon\db\dataMapper\Repository,
    app\entities\ArticleSubcat;

/**
 * @author imndsu@gmail.com
 */
class ArticleSubcatsRepository extends Repository
{
    public function __construct(ArticleSubcat $entity, ...$params)
    {
        $this->entity = $entity;

        parent::__construct(...$params);
    }
}
