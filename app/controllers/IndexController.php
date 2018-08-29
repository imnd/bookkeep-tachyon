<?php
namespace app\controllers;

/**
 * Контроллер начальной страницы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class IndexController extends \tachyon\Controller
{
    /**
     * Главная страница
     */
    public function index()
	{
		$this->layout();
	}

    /**
     * @return array
     */
    public function getMainMenu()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getSubMenu()
    {
        return array();
    }
}
