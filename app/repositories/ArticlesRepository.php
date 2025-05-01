<?php
namespace app\repositories;

use app\traits\ConditionsTrait,
    Iterator,
    tachyon\db\dataMapper\Repository,
    tachyon\db\dbal\conditions\Terms,
    tachyon\traits\RepositoryListTrait,
    app\entities\Article
;

/**
 * @author imndsu@gmail.com
 */
class ArticlesRepository extends Repository
{
    use ConditionsTrait;
    use RepositoryListTrait;

    public function __construct(
        Article $article,
        protected ArticleSubcatsRepository $articleSubcatRepository,
        protected Terms $terms,
        ...$params
    ) {
        $this->entity = $article;

        parent::__construct(...$params);
    }

    public function findAll(array $where = [], array $sort = []): Iterator
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

    public function setSearchConditions(array $conditions = []): Repository
    {
        $conditions = array_merge(
            $this->terms->gt($conditions, 'price', 'priceFrom'),
            $this->terms->lt($conditions, 'price', 'priceTo')
        );

        parent::setSearchConditions($conditions);

        return $this;
    }

    public function getUnits(): array
    {
        return ['кг', 'шт'];
    }
}
