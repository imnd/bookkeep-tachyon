<?php
namespace app\views\widgets\menu;

use tachyon\components\widgets\Widget;

/**
 * class Menu
 * Отображает меню
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Menu extends Widget
{
    /**
     * Пункты меню
     * @var $items array
     */
    protected array $items = [];

    public function run()
    {
        if (!empty($this->items)) {
            $this->display($this->viewsPath, [
                'items' => $this->items,
            ]);
        }
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
     * @param $url
     * @return string
     */
    public function getBtnHref($url)
    {
        if (strpos($url, '/')===0) {
            return $url;
        }
        return "/{$this->controller->getId()}/$url";
    }
}
