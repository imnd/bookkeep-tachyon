<?php
namespace app\interfaces;

use tachyon\db\dataMapper\Entity;

interface RowEntityInterface
{
    # region Getters

    public function getQuantity(): ?int;

    public function getPrice(): ?int;

    /**
     * @return string
     */
    public function getRowFk(): string;

    # endregion

    # region Setters

    public function setQuantity(int $value = null): Entity;

    public function setPrice(int $value = null): Entity;

    /**
     * @param int|null $value
     *
     * @return void
     */
    public function setRowFkProp(int $value = null): void;

    # endregion
}
