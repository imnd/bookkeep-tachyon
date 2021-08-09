<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Позиция фактуры"
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class InvoiceRow extends Row
{
    protected string $tableName = 'invoices_rows';

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
     * @var string
     */
    protected string $articleName;
    /**
     * @var string
     */
    protected string $articleUnit;
    /**
     * @var string
     */
    protected string $sum;
    /**
     * @var int
     */
    protected int $invoiceId;

    # region Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function getArticleName(): string
    {
        return $this->articleName;
    }

    public function getArticleUnit(): string
    {
        return $this->articleUnit;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function getSum(): string
    {
        return $this->sum;
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

    # endregion

    # region Setters

    public function setArticleId(int $value = null): InvoiceRow
    {
        return $this->_setAttribute('articleId', $value);
    }

    public function setArticleName(string $value = null): InvoiceRow
    {
        return $this->_setAttribute('articleName', $value);
    }

    public function setArticleUnit(string $value = null): InvoiceRow
    {
        return $this->_setAttribute('articleUnit', $value);
    }

    public function setInvoiceId(int $value = null): InvoiceRow
    {
        return $this->_setAttribute('invoiceId', $value);
    }

    public function setSum(int $value = null): InvoiceRow
    {
        return $this->_setAttribute('sum', $value);
    }

    public function setAttributes(array $state): void
    {
        parent::setAttributes($state);

        $this
            ->setArticleId($state['articleId'] ?? null)
            ->setInvoiceId($state['invoice_id'] ?? null)
        ;
    }

    # endregion
}
