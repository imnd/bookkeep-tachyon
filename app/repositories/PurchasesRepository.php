<?php
namespace app\repositories;

use app\entities\Purchase;

/**
 * @author imndsu@gmail.com
 */
class PurchasesRepository extends HasRowsRepository
{
    public function __construct(Purchase $purchase, ...$params)
    {
        $this->entity = $purchase;

        parent::__construct(...$params);
    }
 
    public function setSearchConditions(array $conditions = []): static
    {
        $conditions = $this->setYearBorders($conditions, 't');

        parent::setSearchConditions($conditions);

        return $this;
    }
}
