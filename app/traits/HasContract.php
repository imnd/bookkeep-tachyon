<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
trait HasContract
{
    /**
     * @var int
     */
    protected string $contractNum = '';
    /**
     * @var string
     */
    protected string $contractType;

    /**
     * @return int
     */
    public function getContractNum()
    {
        return $this->contractNum;
    }

    /**
     * @return string
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    /**
     * @param int|null $value
     * @return Entity
     */
    public function setContractNum(int $value = null)
    {
        return $this->_setAttribute('contractNum', $value);
    }

    /**
     * @param string|null $value
     * @return Entity
     */
    public function setContractType(string $value = null)
    {
        return $this->_setAttribute('contractType', $value);
    }
}
