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
class SettingsController extends CrudController
{
    protected $layout = 'settings';

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
    public function requisites(Settings $settings)
    {
        $requisiteKeys = [
            'firm' => ['director', 'name_short', 'name', 'inn', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo'],
            'supplier' => ['name_short', 'name', 'bik', 'inn', 'kpp', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo'],
        ];
        if (!empty($this->post)) {
            $result = true;
            foreach ($requisiteKeys as $type => $keys) {
                foreach ($keys as $key) {
                    $confKey = $type . "_$key";
                    $model = $settings->findByKey($confKey);
                    $value = $this->post[$confKey];
                    if ($value != $model->value) {
                        $model->value = $value;
                        $result = $result && $model->save();
                    }
                }
            }
            if ($result) {
                $this->redirect($this->getRoute());
            }
        }
        $requisitesAll = [
            'firm' => array(),
            'supplier' => array(),
        ];
        foreach ($requisiteKeys as $type => $keys) {
            foreach ($keys as $key) {
                $confKey = $type . "_$key";
                $requisitesAll[$type][$key] = [
                    'name' => $settings->getNameByKey($confKey),
                    'value' => $settings->getValueByKey($confKey),
                ];
            }
        }
        $this->layout('requisites', compact('requisitesAll'));
    }

    /**
     * Создание резервной копии и установка путей для её сохранения
     * @param app\models\Settings $settings
     */
    public function backup(Settings $settings)
    {
        $this->layout('backup', [
            'paths' => $settings->getPaths(),
        ]);
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
     * @param tachyon\components\FilesManager $filesManager
     */
    public function acceptFile(FilesManager $filesManager)
    {
        $complete = false;

        $data = $this->files['data'];

        $filesManager->saveChunk($data['tmp_name']);
        $chunks = $filesManager->getChunkNames();
        if (count($chunks)==$_GET['chunksCount']) {
            $complete = $filesManager->spliceChunks($chunks, $data['name']);
        }

        echo json_encode(compact('complete'));
    }
}