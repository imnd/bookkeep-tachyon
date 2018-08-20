<?php
namespace app\controllers;

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
     * Список районов
     */
    public function index()
    {
        $model = \tachyon\dic\Container::getInstanceOf('Regions');
        $this->layout('index', array(
            'model' => $model,
            'items' => $model
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->getAllByConditions(),
        ));
    }
}
