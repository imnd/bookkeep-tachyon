<?php
namespace app\controllers;

use app\models\Regions;

/**
 * class Regions
 * Контроллер районов города
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class RegionsController extends \app\components\CrudController
{
    /**
     * Regions model
     * @var app\models\Regions
     */
    protected $regions;

    /**
     * @param Regions $regions
     */
    public function __construct(Regions $regions, ...$params)
    {
        $this->regions = $regions;

        parent::__construct(...$params);
    }

    /**
     * Список районов
     */
    public function index()
    {
        $this->layout('index', array(
            'model' => $this->regions,
            'items' => $this->regions
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(),
        ));
    }
}
