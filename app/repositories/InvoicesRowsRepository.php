<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Entity;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class InvoicesRowsRepository extends RowsRepository
{
    protected $articlesRepository;

    /**
     * @param ArticlesRepository $articlesRepository
     * @param array $params
     */
    public function __construct(
        ArticlesRepository $articlesRepository,
        ...$params
    )
    {
        $this->articlesRepository = $articlesRepository;

        parent::__construct(...$params);
    }

    /**
     * @param array $arrayData
     * @return Iterator
     */
    protected function convertArrayData($arrayData): Iterator
    {
        foreach ($arrayData as $data) {
            $entity = $this->entity->fromState($data);
            $entity = $this->setArticle($entity);

            yield $this->collection[$entity->getPk()] = $entity;
        }
    }

    /**
     * @inheritdoc
     */
    public function findByPk($pk): ?Entity
    {
        $entity = parent::findByPk($pk);

        return $this->setArticle($entity);
    }

    /**
     * @param  $entity
     * @return 
     */
    private function setArticle($entity)
    {
        /** @var Article */ 
        if (
            $article = $this->articlesRepository
                ->findByPk($entity->getArticleId())
        ) {
            $entity
                ->setArticleName($article->getName())
                ->setArticleUnit($article->getUnit())
            ;
        }
        return $entity;
    }
}
