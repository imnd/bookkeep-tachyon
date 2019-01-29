<?php
namespace app\dic;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
trait Region
{
    /**
     * Region entity
     * @var \app\entities\Region
     */
    protected $region;

    /**
     * @param \app\entities\Region $service
     * @return void
     */
    public function setRegion(\app\entities\Region $service)
    {
        $this->region = $service;
    }
}
