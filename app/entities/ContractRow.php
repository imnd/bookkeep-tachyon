<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Строка контракта"
 *
 * @author imndsu@gmail.com
 */
class ContractRow extends Row
{
    protected string $tableName = 'contracts_rows';

    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->attributeCaptions['articleId'] = 'товар';
    }

    protected int $id;
    protected ?int $articleId = null;
    protected ?int $contractId = null;

    # region Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function getContractId(): ?int
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

    # endregion

    # region Setters

    public function setArticleId(int $value = null): ContractRow
    {
        return $this->_setAttribute('articleId', $value);
    }

    public function setContractId(int $value = null): ContractRow
    {
        return $this->_setAttribute('contractId', $value);
    }

    public function setAttributes(array $state): void
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleId'] ?? null)
            ->setContractId($state['contract_id'] ?? null)
        ;
    }

    # endregion
}
