<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class InvoiceRow extends RowEntity
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
    protected $invoiceId;

    # Getters

    public function getId()
    {
        return $this->id;
    }

    public function getArticleId()
    {
        return $this->articleId;
    }

    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    public function getAttributes(): array
    {
        return array_merge(parent::getAttributes(), [
            'article_id' => $this->articleId,
            'invoice_id' => $this->invoiceId,
        ]);
    }

    public function fromState(array $state): Entity
    {
        $entity = parent::fromState($state);

        $entity->id = $state['id'];
        $entity->articleId = $state['article_id'] ?? null;
        $entity->invoiceId = $state['invoice_id'] ?? null;

        return $entity;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), ['articleId' => 'numerical']);
    }

    # Setters

    public function setArticleId(int $value = null): InvoiceRow
    {
        return $this->_setAttribute('articleId', $value);
    }

    public function setInvoiceId(int $value = null): InvoiceRow
    {
        return $this->_setAttribute('invoiceId', $value);
    }

    public function setAttributes(array $state)
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleId'] ?? null)
            ->setInvoiceId($state['invoice_id'] ?? null)
        ;
    }
}
