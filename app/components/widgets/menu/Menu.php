<?php
namespace app\components\widgets\menu;

/**
 * class Menu
 * Отображает меню
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class Menu extends \tachyon\components\widgets\Widget
{
    /**
     * Пункты меню
     * @var $items array
     */
    protected $items = array();

    public function run()
    {
        if (!empty($this->items))
            $this->display($this->view, array(
                'items' => $this->items,
                'controller' => $this->controller,
            ));
    }

    /**
     * getBtnId
     * 
     * @param $action string
     * @return string
     */
    public function getBtnId($action)
    {
        return md5($action);
    }

    /**
     * getBtnHref
     * 
     * @param $action string
     * @return string
     */
    public function getBtnHref($url)
    {
        if (strpos($url, '/')===0)
            return $url;

        return "/{$this->controller->getId()}/$url";
    }
}