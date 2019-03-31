<?php
namespace app\models;

/**
 * Класс модели строки договора
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsRows extends RowsModel
{
    use \app\traits\Article;

    protected static $tableName = 'contracts_rows';
    protected $pkName = 'id';
    protected $fields = array('article_id');

    protected $parentKey = 'contract_id';
    protected $fieldTypes = [
        'article_id' => 'smallint',
    ];
    protected $attributeTypes = [
        'article_id' => 'select',
    ];
    protected $attributeNames = [
        'article_id' => 'товар',
    ];
    protected $relations = [
        'article' => array('Articles', 'has_one', 'article_id'),
    ];

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'article_id' => array('numerical'),
        ]);
    }

    /**
     * @param $contractID integer
     * @return array
     */
    public function getAllByContract($contractId=null): array
    {
        return $this->findAllRaw(array('contract_id' => $contractId));
    }

    /**
     * @param array $conditions условия поиска
     * @return array
     */
    public function findAllRaw(array $conditions=array()): array
    {
        $this
            ->join(
                array('articles' => 'art'),
                array('article_id', 'id')
            )
            ->join(
                array(ArticleSubcats::getTableName() => 'subcat'),
                array('subcat_id', 'id'),
                'art'
            )
            ->join(
                array(ArticleCats::getTableName() => 'cat'),
                array('cat_id', 'id'),
                'subcat'
            )
            ->select([
                '*',
                'art.name' => 'art_name',
                'art.unit' => 'art_unit',
                'subcat.name' => 'subcat_name',
                'cat.name' => 'cat_name',
                'cat.description' => 'cat_description',
            ])
            ->sortBy('cat.id');

        return parent::findAllRaw($conditions);
    }
}
