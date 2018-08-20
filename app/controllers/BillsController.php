<?php
namespace app\controllers;

/**
 * class Bills
 * Контроллер платежей
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class BillsController extends \app\components\CrudController
{
    protected $mainMenu = array(
        'index' => 'баланс',
        'create' => 'добавить запись',
    );
}