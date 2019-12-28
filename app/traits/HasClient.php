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
    public function getClientAddress()
    {
        return $this->clientAddress;
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
    public function getClientAccount()
    {
        return $this->clientAccount;
    }

    /**
     * @return string
     */
    public function getClientBank()
    {
        return $this->clientBank;
    }

    /**
     * @return string
     */
    public function getClientINN()
    {
        return $this->clientINN ?? null;
    }

    /**
     * @return string
     */
    public function getClientKPP()
    {
        return $this->clientKPP ?? null;
    }

    /**
     * @param int|null $value
     * @return self
     */
    public function setClientId(int $value = null)
    {
        return $this->_setAttribute('clientId', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientAddress(string $value = null)
    {
        return $this->_setAttribute('clientAddress', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientAccount(string $value = null)
    {
        return $this->_setAttribute('clientAccount', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientBank(string $value = null)
    {
        return $this->_setAttribute('clientBank', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientName(string $value = null)
    {
        return $this->_setAttribute('clientName', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientINN(string $value = null)
    {
        return $this->_setAttribute('clientINN', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientKPP(string $value = null)
    {
        return $this->_setAttribute('clientKPP', $value);
    }
}
