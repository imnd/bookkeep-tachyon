<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ContractRow extends RowEntity
{
    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->attributeCaptions['articleId'] = 'товар';
    }

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $articleId;
    /**
     * @var int
     */
    protected $contractId;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function getContractId()
    {
        return $this->contractId;
    }

    public function getAttributes(): array
    {
        return array_merge(parent::getAttributes(), [
            'article_id' => $this->articleId,
            'contract_id' => $this->contractId,
        ]);
    }

    public function fromState(array $state): Entity
    {
        $entity = parent::fromState($state);

        $entity->id = $state['id'];
        $entity->articleId = $state['article_id'] ?? null;
        $entity->contractId = $state['contract_id'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), ['articleId' => 'numerical']);
    }

    # Setters

    public function setArticleId(int $value = null): ContractRow
    {
        return $this->_setAttribute('articleId', $value);
    }

    public function setContractId(int $value = null): ContractRow
    {
        return $this->_setAttribute('contractId', $value);
    }

    public function setAttributes(array $state)
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleId'] ?? null)
            ->setContractId($state['contract_id'] ?? null)
        ;
    }
}
