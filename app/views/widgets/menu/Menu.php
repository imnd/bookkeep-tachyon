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

    public function run(): void
    {
        if (!empty($this->items)) {
            $this->display($this->viewsPath, [
                'items' => $this->items,
            ]);
        }
    }

    /**
     * @param $action string
     *
     * @return string
     */
    public function getBtnId(string $action): string
    {
        return md5($action);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getBtnHref(string $url): string
    {
        if (strpos($url, '/')===0) {
            return $url;
        }
        return "/{$this->controller->getId()}/$url";
    }
}
