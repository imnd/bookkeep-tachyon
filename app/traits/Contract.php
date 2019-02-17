<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait Contract
{
    /**
     * @return integer
     */
    public function getContractId()
    {
        if ($contract = $this->contract) {
            return $contract->id;
        }
    }

    /**
     * @return integer
     */
    public function getContractType()
    {
        if ($contract = $this->contract) {
            return $contract->getTypeName();
        }
    }
}
