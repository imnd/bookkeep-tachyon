<?php

namespace app\controllers;

use
    tachyon\Controller,
    tachyon\components\FilesManager,
    tachyon\traits\Auth,
    app\models\Settings;

use tachyon\exceptions\{
    DBALException, ValidationException
};

/**
 * Контроллер настроек приложения
 *
 * @author imndsu@gmail.com
 */
class SettingsController extends Controller
{
    use Auth;

    protected string $layout = 'settings';

    /**
     * Главная страница
     */
    public function index(): void
    {
        $this->view();
    }

    /**
     * Установка реквизитов
     */
    public function requisites(Settings $settings): void
    {
        $requisiteKeys = [
            'firm' => [
                'director',
                'name_short',
                'name',
                'inn',
                'bank',
                'account',
                'address',
                'certificate',
                'okud',
                'okpo',
            ],
            'supplier' => [
                'name_short',
                'name',
                'bik',
                'inn',
                'kpp',
                'bank',
                'account',
                'address',
                'certificate',
                'okud',
                'okpo',
            ],
        ];
        if (!empty($postParams = $this->request->getPost())) {
            $result = true;
            foreach ($requisiteKeys as $type => $keys) {
                foreach ($keys as $key) {
                    $confKey = "{$type}_$key";
                    $model = $settings->findByKey($confKey);
                    $value = $postParams[$confKey];
                    if ($value != $model->value) {
                        $model->value = $value;
                        $result = $result && $model->save();
                    }
                }
            }
            if ($result) {
                $this->redirect($this->request->getRoute());
            }
        }
        $requisitesAll = [
            'firm' => [],
            'supplier' => [],
        ];
        foreach ($requisiteKeys as $type => $keys) {
            foreach ($keys as $key) {
                $confKey = "{$type}_$key";
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
     */
    public function backup(Settings $settings): void
    {
        $this->view(
            'backup',
            [
                'paths' => $settings->getPaths(),
            ]
        );
    }

    /**
     * Загрузка файла на сервер по частям
     */
    public function upload(): void
    {
        $this->view('upload');
    }

    /**
     * AJAX-handler загрузки частей файла на сервер и сборки файла
     */
    public function acceptFile(FilesManager $filesManager): void
    {
        $complete = false;
        $data = $this->files['data'];
        $filesManager->saveChunk($data['tmp_name']);
        $chunks = $filesManager->getChunkNames();
        if (count($chunks) === (int)$_GET['chunksCount']) {
            $complete = $filesManager->spliceChunks($chunks, $data['name']);
        }
        echo json_encode(compact('complete'));
    }
}
