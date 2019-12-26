<?php
namespace app\controllers;

use tachyon\db\dataMapper\Entity,
    tachyon\components\Flash,
    tachyon\helpers\ArrayHelper;

/**
 * class Controller
 * Базовый класс для всех контроллеров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class HasRowsController extends CrudController
{
    protected $rowRepository;

    /**
     * @param Entity $entity
     * @return boolean
     */
    protected function save(Entity $entity)
    {
        if (empty($postParams = Request::getPost())) {
            return false;
        }
        $errors = [];
        // сохраням
        $entity->setAttributes($postParams);
        if (!$entity->save()) {
            $errors[] = $entity->getErrorsSummary();
        }
        // удалям строки
        if ($rows = $entity->getRows()) {
            foreach ($rows as $row) {
                $row->markDeleted();
            }
        }
        // сохраням строки
        $sum = 0;
        $rowsData = ArrayHelper::transposeArray($postParams);
        foreach ($rowsData as $rowData) {
            $row = $this->rowRepository->create();
            $rowData[$row->getRowFk()] = $entity->getPk();
            $row->setAttributes($rowData);
            if (!$row->validate()) {
                $errors[] = $row->getErrorsSummary();
                unset($row);
            }
            $sum += $rowData['row_sum'];
        }
        // сохраням
        $entity->setSum($sum);
        if (!$entity->getDbContext()->commit()) {
            $errors[] = $entity->getErrorsSummary();
        }
        if (!empty($errors)) {
            $this->flash->addFlash('Что то пошло не так, ' . implode("\n", $errors), Flash::FLASH_TYPE_ERROR);
            return false;
        }
        $this->flash->addFlash('Сохранено успешно', Flash::FLASH_TYPE_SUCCESS);
        return true;
    }
}
