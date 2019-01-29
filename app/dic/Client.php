<?php
namespace app\dic;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
trait Client
{
    /**
     * Client entity
     * @var \app\entities\Client
     */
    protected $client;

    /**
     * @param \app\entities\Client $service
     * @return void
     */
    public function setClient(\app\entities\Client $service)
    {
        $this->client = $service;
    }
}
