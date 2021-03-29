<?php
namespace app\repositories;

use
    Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\traits\RepositoryListTrait,
    app\entities\Article
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ArticlesRepository extends Repository
{
    /**
     * @var Article
     */
    protected Article $article;

    use RepositoryListTrait;

    /**
     * @var ArticleSubcatsRepository
     */
    protected ArticleSubcatsRepository $articleSubcatRepository;

    /**
     * @param Article $article
     * @param ArticleSubcatsRepository $articleSubcatRepository
     * @param array $params
     */
    public function __construct(
        Article $article,
        ArticleSubcatsRepository $articleSubcatRepository,
        ...$params
    )
    {
        $this->entity = $article;
        $this->articleSubcatRepository = $articleSubcatRepository;

        parent::__construct(...$params);
    }

    public function findAll(array $where = array(), array $sort = array()): Iterator
    {
        $arrayData = $this->persistence
            ->select([
                'a.id',
                'a.name',
                'a.unit',
                'a.price',
                'a.active',
                's.name' => 'subcatName'
            ])
            ->from($this->tableName)
            ->asa('a')
            ->with([
                $this->articleSubcatRepository->getTableName() => 's'
            ], [
                'subcat_id' => 'id'
            ])
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }

    /**
     * @param array $conditions условия поиска
     * @return ArticlesRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $this->where = array_merge(
            $this->gt($conditions, 'price', 'priceFrom'),
            $this->lt($conditions, 'price', 'priceTo')
        );

        parent::setSearchConditions($conditions);

        return $this;
    }

    /**
     * @return array
     */
    public function getUnits()
    {
        return ['кг', 'шт'];
    }
}
