<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait MenuTrait
{
    /**
     * Главное меню
     * @var $mainMenu array
     */
    protected $mainMenu = array();
    /**
     * Меню страницы
     * @var $subMenu array
     */
    protected $subMenu = array();

    # сеттеры

    /**
     * @param $subMenu array
     * @return void
     */
    public function setSubMenu(array $subMenu)
    {
        $this->subMenu = $subMenu;
    }

    # геттеры

    /**
     * @return array
     */
    public function getMainMenu(): array
    {
        return $this->mainMenu;
    }

    /**
     * @return array
     */
    public function getSubMenu(): array
    {
        return $this->subMenu;
    }
}
