<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait Client
{
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
    
    
    
    // переделать
    
    /**
     * @return string
     */
    public function getClientAccount()
    {
        if ($client = $this->client) {
            return $client->getAccount();
        }
    }

    /**
     * @return string
     */
    public function getClientAddress()
    {
        if ($client = $this->client) {
            return $client->getAddress();
        }
    }

    /**
     * @return string
     */
    public function getClientBank()
    {
        if ($client = $this->client) {
            return $client->getBank();
        }
    }

    /**
     * @return string
     */
    public function getClientContactPost()
    {
        if ($client = $this->client) {
            return $client->getContactPost();
        }
    }

    /**
     * @return string
     */
    public function getClientContactFio()
    {
        if ($client = $this->client) {
            return $client->getContactFio();
        }
    }

    /**
     * @return string
     */
    public function getClientINN()
    {
        if ($client = $this->client) {
            return $client->getINN();
        }
    }

    /**
     * @return string
     */
    public function getClientKPP()
    {
        if ($client = $this->client) {
            return $client->getKPP();
        }
    }

    /**
     * @return string
     */
    public function getClientBIK()
    {
        if ($client = $this->client) {
            return $client->getBIK();
        }
    }

    /**
     * @return string
     */
    public function getClientCorrSchet()
    {
        if ($client = $this->client) {
            return $client->getCorrSchet();
        }
    }
}
