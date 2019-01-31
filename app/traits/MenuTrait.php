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
    protected $mainMenu = [
        'index' => 'список',
        'create' => 'добавить',
    ];
    /**
     * Меню страницы
     * @var $subMenu array
     */
    protected $subMenu = array();

    # сеттеры

    /**
     * @return void
     */
    public function setMainMenu(array $menu)
    {
        $this->mainMenu = $menu;
    }

    /**
     * @param $subMenu array
     * @return void
     */
    public function setSubMenu(array $menu)
    {
        $this->subMenu = $menu;
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
