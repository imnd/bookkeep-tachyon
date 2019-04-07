<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait HasClient
{
    /**
     * @var int
     */
    protected $clientId;
    /**
     * @var string
     */
    protected $clientName;
    /**
     * @var string
     */
    protected $clientAddress;

    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @return string
     */
    public function getClientNameAndAddress()
    {
        $str = $this->clientName;
        if (!empty($this->clientAddress)) {
            $str .= " ({$this->clientAddress})";
        }
        return $str;
    }

    /**
     * @return string
     */
    public function setClientId(int $value = null)
    {
        return $this->_setAttribute('clientId', $value);
    }
}
