<?php
namespace app\controllers;

/**
 * Контроллер настроек приложения
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class SettingsController extends \app\components\CrudController
{
    protected $mainMenu = array(
        'requisites' => 'реквизиты',
        'backup' => 'резервная копия',
    );

    public function init()
    {
        parent::init();

        $this->view->setPageTitle('Администрирование');
    }

    /**
     * Главная страница
     */
    public function index()
	{
		$this->layout();
	}

    /**
     * Установка реквизитов
     */
    public function requisites()
    {
        $requisiteKeys = array(
            'firm' => array('director', 'name_short', 'name', 'inn', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo',),
            'supplier' => array('name_short', 'name', 'bik', 'inn', 'kpp', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo'),
        );
        if (!empty($this->post)) {
            $result = true;
            foreach ($requisiteKeys as $type => $keys)
                foreach ($keys as $key) {
                    $confKey = $type . "_$key";
                    $model = $this->model->findByKey($confKey);
                    $value = $this->post[$confKey];
                    if ($value!=$model->value) {
                        $model->value = $value;
                        $result = $result && $model->save();
                    }
                }

            if ($result)
                $this->redirect($this->getRoute());
        }
        $requisitesAll = array(
            'firm' => array(),
            'supplier' => array(),
        );
        foreach ($requisiteKeys as $type => $keys) {
            foreach ($keys as $key) {
                $confKey = $type . "_$key";
                $requisitesAll[$type][$key] = array(
                    'name' => $this->model->getNameByKey($confKey),
                    'value' => $this->model->getValueByKey($confKey),
                );
            }
        }
        $this->layout('requisites', compact('requisitesAll'));
    }

    /**
     * Создание резервной копии и установка путей для её сохранения
     */
    public function backup()
    {
        $this->layout('backup', array(
            'paths' => $this->get('Settings')->getPaths(),
        ));
    }
}