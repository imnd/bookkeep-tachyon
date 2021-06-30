<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Строка поставки"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class PurchaseRow extends Row
{
    protected string $tableName = 'purchases_rows';

    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->attributeCaptions['articleSubcatId'] = 'товар';
    }

    /**
     * @var int
     */
    protected int $id;
    /**
     * @var int|null
     */
    protected ?int $articleSubcatId;
    /**
     * @var int|null
     */
    protected ?int $purchaseId;

    # Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticleId(): ?int
    {
        return $this->articleSubcatId;
    }

    public function getPurchaseId(): ?int
    {
        return $this->purchaseId;
    }

    public function getAttributes(): array
    {
        return array_merge(parent::getAttributes(), [
            'article_subcategory_id' => $this->articleSubcatId,
            'purchase_id' => $this->purchaseId,
        ]);
    }

    public function fromState(array $state): Entity
    {
        $entity = parent::fromState($state);

        $entity->id = $state['id'];
        $entity->articleSubcatId = $state['article_subcategory_id'] ?? null;
        $entity->purchaseId = $state['purchase_id'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), ['articleSubcatId' => 'numerical']);
    }

    # Setters

    public function setArticleId(int $value = null): self
    {
        return $this->_setAttribute('articleSubcatId', $value);
    }

    public function setPurchaseId(int $value = null): self
    {
        return $this->_setAttribute('purchaseId', $value);
    }

    public function setAttributes(array $state): void
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleSubcatId'] ?? null)
            ->setPurchaseId($state['purchase_id'] ?? null)
        ;
    }
}
