<?php
namespace app\dic;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
trait Users
{
    /**
     * Client entity
     * @var app\models\Users
     */
    protected $users;

    /**
     * @param app\models\Users $service
     * @return void
     */
    public function setUsers(\app\models\Users $service)
    {
        $this->users = $service;
    }
}
