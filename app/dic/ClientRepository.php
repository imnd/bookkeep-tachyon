<?php
namespace app\dic;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
trait ClientRepository
{
    /**
     * @var \app\repositories\ClientRepository
     */
    protected $clientRepository;

    /**
     * @param \app\repositories\ClientRepository $service
     * @return void
     */
    public function setClientRepository(\app\repositories\ClientRepository $service)
    {
        $this->clientRepository = $service;
    }
}
