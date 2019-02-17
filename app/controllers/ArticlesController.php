<?php
namespace app\controllers;

/**
 * Контроллер товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ArticlesController extends \app\components\CrudController
{
    /**
     * Главная страница, список товаров
     */
    public function index()
    {
        $this->layout('index', array(
            'model' => $this->model,
            'items' => $this->model
                ->join(array(\app\models\ArticleSubcats::getTableName() => 'sс'), array('subcat_id', 'id'))
                ->select(array('*', 'sс.name' => 'subcatName'))
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(),
        ));
    }
}