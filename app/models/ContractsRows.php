<?php
namespace app\models;

/**
 * Класс модели строки договора
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsRows extends \app\components\RowsModel
{
    use \app\traits\ArticleTrait;

    protected static $tableName = 'contracts_rows';
    protected $pkName = 'id';
    protected $fields = array('article_id');

    protected static $parentKey = 'contract_id';
    protected $fieldTypes = array(
        'article_id' => 'smallint',
    );
    protected $attributeTypes = array(
        'article_id' => 'select',
    );
    protected $attributeNames = array(
        'article_id' => 'товар',
    );
    protected $relations = array(
        'article' => array('Articles', 'has_one', 'article_id'),
    );

    public function rules(): array
    {
        return array_merge(parent::rules(), array(
            'article_id' => array('numerical'),
        ));
    }

    /**
     * @param $contractID integer
     * @return array
     */
    public function getAllByContract($contractId=null): array
    {
        return $this->findAllScalar(array('contract_id' => $contractId));
    }
    
    /**
     * @param array $conditions условия поиска
     */
    public function findAllScalar(array $conditions=array()): array
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
            ->select(array(
                '*',
                'art.name' => 'art_name',
                'art.unit' => 'art_unit',
                'subcat.name' => 'subcat_name',
                'cat.name' => 'cat_name',
                'cat.description' => 'cat_description',
            ))
            ->sortBy('cat.id');

        return parent::findAllScalar($conditions);
    }
}
