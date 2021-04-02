<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ContractRow extends Row
{
    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->attributeCaptions['articleId'] = 'товар';
    }

    /**
     * @var int
     */
    protected int $id;
    /**
     * @var int
     */
    protected ?int $articleId = null;
    /**
     * @var int
     */
    protected int $contractId;

    # Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function getContractId(): int
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

    # SETTERS

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
