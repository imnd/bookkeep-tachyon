<?php
namespace app\repositories;

use Iterator,
    tachyon\db\dataMapper\Repository,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ArticleSubcatRepositoryInterface,
    app\entities\Article,
    app\traits\Select
;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ArticleRepository extends Repository implements ArticleRepositoryInterface
{
    use Select;

    /**
     * @var app\entities\Article
     */
    protected $article;
    /**
     * @var app\interfaces\ArticleSubcatRepositoryInterface
     */
    protected $articleSubcatRepository;

    public function __construct(
        Article $article,
        ArticleSubcatRepositoryInterface $articleSubcatRepository,
        ...$params
    )
    {
        $this->article = $article;
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
            ->with([$this->articleSubcatRepository->getTableName() => 's'], ['subcat_id' => 'id'])
            ->findAll($where, $sort);

        return $this->convertArrayData($arrayData);
    }

    /**
     * @param array $conditions условия поиска
     * @return ArticleRepository
     */
    public function setSearchConditions($conditions = array()): Repository
    {
        $this->where = array_merge(
            $this->terms->gt($conditions, 'price', 'priceFrom'),
            $this->terms->lt($conditions, 'price', 'priceTo')
        );
        
        parent::setSearchConditions($conditions);

        return $this;
    }
}
