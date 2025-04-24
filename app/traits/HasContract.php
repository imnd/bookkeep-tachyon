<?php
namespace app\traits;

use tachyon\db\dataMapper\Entity;

/**
 * @author imndsu@gmail.com
 */
trait HasContract
{
    /**
     * @var string
     */
    protected string $contractNum = '';
    /**
     * @var string
     */
    protected string $contractType;

    /**
     * @return string
     */
    public function getContractNum(): string
    {
        return $this->contractNum;
    }

    /**
     * @return string
     */
    public function getContractType(): string
    {
        return $this->contractType;
    }

    /**
     * @param int|null $value
     * @return Entity
     */
    public function setContractNum(int $value = null): Entity
    {
        return $this->_setAttribute('contractNum', $value);
    }

    /**
     * @param string|null $value
     * @return Entity
     */
    public function setContractType(string $value = null): Entity
    {
        return $this->_setAttribute('contractType', $value);
    }
}
