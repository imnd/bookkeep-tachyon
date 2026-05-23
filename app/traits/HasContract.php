<?php
namespace app\traits;

use tachyon\db\dataMapper\Entity;

/**
 * @author imndsu@gmail.com
 */
trait HasContract
{
    protected string $contractNum = '';
    protected string $contractType;

    public function getContractNum(): string
    {
        return $this->contractNum;
    }

    public function getContractType(): string
    {
        return $this->contractType;
    }

    public function setContractNum(int $value = null): Entity
    {
        return $this->_setAttribute('contractNum', $value);
    }

    public function setContractType(string $value = null): Entity
    {
        return $this->_setAttribute('contractType', $value);
    }
}
