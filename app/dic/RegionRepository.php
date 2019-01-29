<?php
namespace app\dic;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
trait RegionRepository
{
    /**
     * @var \app\repositories\RegionRepository
     */
    protected $regionRepository;

    /**
     * @param \app\repositories\RegionRepository $service
     * @return void
     */
    public function setRegionRepository(\app\repositories\RegionRepository $service)
    {
        $this->regionRepository = $service;
    }
}
