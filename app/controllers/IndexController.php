<?php
namespace app\controllers;

/**
 * Контроллер начальной страницы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class IndexController extends \app\components\CrudController
{
    protected $mainMenu = array();
    
    /**
     * Главная страница
     */
    public function index()
	{
		$this->layout();
	}
}
