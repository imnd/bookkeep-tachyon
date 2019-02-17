<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait Client
{
    /**
     * @return string
     */
    public function getClientName()
    {
        if ($client = $this->client) {
            return $client->name;
        }
    }

    /**
     * @return string
     */
    public function getClientAccount()
    {
        if ($client = $this->client) {
            return $client->account;
        }
    }

    /**
     * @return string
     */
    public function getClientAddress()
    {
        if ($client = $this->client) {
            return $client->address;
        }
    }

    /**
     * @return string
     */
    public function getClientBank()
    {
        if ($client = $this->client) {
            return $client->bank;
        }
    }

    /**
     * @return string
     */
    public function getClientContactPost()
    {
        if ($client = $this->client) {
            return $client->contact_post;
        }
    }

    /**
     * @return string
     */
    public function getClientContactFio()
    {
        if ($client = $this->client) {
            return $client->contact_fio;
        }
    }

    /**
     * @return string
     */
    public function getClientINN()
    {
        if ($client = $this->client) {
            return $client->INN;
        }
    }

    /**
     * @return string
     */
    public function getClientKPP()
    {
        if ($client = $this->client) {
            return $client->KPP;
        }
    }

    /**
     * @return string
     */
    public function getClientBIK()
    {
        if ($client = $this->client) {
            return $client->BIK;
        }
    }

    /**
     * @return string
     */
    public function getClientCorrSchet()
    {
        if ($client = $this->client) {
            return $client->korr_schet;
        }
    }
}
