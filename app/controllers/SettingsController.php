<?php
namespace app\controllers;

use
    tachyon\Controller,
    tachyon\components\FilesManager,
    tachyon\Request,
    tachyon\traits\Auth,
    app\models\Settings
;

/**
 * Контроллер настроек приложения
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class SettingsController extends Controller
{
    use Auth;

    protected $layout = 'settings';

    /**
     * Главная страница
     */
    public function index()
    {
        $this->view();
    }

    /**
     * Установка реквизитов
     * @param Settings $settings
     */
    public function requisites(Settings $settings)
    {
        $requisiteKeys = [
            'firm' => ['director', 'name_short', 'name', 'inn', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo'],
            'supplier' => ['name_short', 'name', 'bik', 'inn', 'kpp', 'bank', 'account', 'address', 'certificate', 'okud', 'okpo'],
        ];
        if (!empty($postParams = Request::getPost())) {
            $result = true;
            foreach ($requisiteKeys as $type => $keys) {
                foreach ($keys as $key) {
                    $confKey = $type . "_$key";
                    $model = $settings->findByKey($confKey);
                    $value = $postParams[$confKey];
                    if ($value != $model->value) {
                        $model->value = $value;
                        $result = $result && $model->save();
                    }
                }
            }
            if ($result) {
                $this->redirect(Request::getRoute());
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
        $this->view('requisites', compact('requisitesAll'));
    }

    /**
     * Создание резервной копии и установка путей для её сохранения
     * @param Settings $settings
     */
    public function backup(Settings $settings)
    {
        $this->view('backup', [
            'paths' => $settings->getPaths(),
        ]);
    }

    /**
     * Загрузка файла на сервер по частям
     */
    public function upload()
    {
        $this->view('upload');
    }

    /**
     * AJAX-handler загрузки частей файла на сервер и сборки файла
     * @param FilesManager $filesManager
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
