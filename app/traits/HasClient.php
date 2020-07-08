<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
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
     * @var string
     */
    protected $clientAccount;
    /**
     * @var string
     */
    protected $clientBank;
    /**
     * @var string
     */
    protected $clientINN;
    /**
     * @var string
     */
    protected $clientKPP;
    /**
     * @var string
     */
    protected $clientContactPost;
    /**
     * @var string
     */
    protected $clientContactFio;

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
     * @return string
     */
    public function getClientContactPost()
    {
        return $this->clientContactPost ?? null;
    }

    /**
     * @return string
     */
    public function getClientContactFio()
    {
        return $this->clientContactFio ?? null;
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

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientContactPost(string $value = null)
    {
        return $this->_setAttribute('clientContactPost', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientContactFio(string $value = null)
    {
        return $this->_setAttribute('clientContactFio', $value);
    }
}
