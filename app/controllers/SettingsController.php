<?php
namespace app\controllers;

use tachyon\components\FilesManager,
    app\models\Settings;

/**
 * Контроллер настроек приложения
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class SettingsController extends \app\components\CrudController
{
    /**
     * @var tachyon\components\FilesManager $filesManager
     */
    protected $filesManager;
    /**
     * @var app\models\Settings
     */
    protected $settings;

    public function __construct(FilesManager $filesManager, Settings $settings, ...$params)
    {
        $this->filesManager = $filesManager;
        $this->settings = $settings;

        parent::__construct(...$params);
    }

    public function init()
    {
        parent::init();
        $this->layout = 'settings';
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
            'paths' => $this->settings->getPaths(),
        ));
    }

    /**
     * Загрузка файла на сервер по частям
     */
    public function upload()
    {
        $this->layout('upload');
    }

    /**
     * AJAX-handler загрузки частей файла на сервер и сборки файла
     */
    public function acceptFile()
    {
        $complete = false;

        $data = $_FILES['data'];

        $this->filesManager->saveChunk($data['tmp_name']);

        $chunks = $this->filesManager->getChunkNames();
        if (count($chunks)==$_GET['chunksCount']) {
            $complete = $this->filesManager->spliceChunks($chunks, $data['name']);
        }

        echo json_encode(compact('complete'));
    }
}