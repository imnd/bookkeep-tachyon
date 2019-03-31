<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class PurchaseRow extends RowEntity
{
    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->attributeCaptions['articleSubcatId'] = 'товар';
    }

    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $articleSubcatId;
    /**
     * @var int
     */
    protected $purchaseId;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getArticleId()
    {
        return $this->articleSubcatId;
    }

    public function getPurchaseId()
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

    public function setArticleId(int $value = null): PurchaseRow
    {
        return $this->_setAttribute('articleSubcatId', $value);
    }

    public function setPurchaseId(int $value = null): PurchaseRow
    {
        return $this->_setAttribute('purchaseId', $value);
    }

    public function setAttributes(array $state)
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleSubcatId'] ?? null)
            ->setPurchaseId($state['purchase_id'] ?? null)
        ;
    }
}
