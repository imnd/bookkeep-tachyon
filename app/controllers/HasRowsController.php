<?php
namespace app\controllers;

use tachyon\db\dataMapper\Entity,
    tachyon\components\Flash,
    tachyon\traits\ArrayTrait,
    app\interfaces\RowsRepositoryInterface;
use tachyon\Request;

/**
 * class Controller
 * Базовый класс для всех контроллеров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class HasRowsController extends CrudController
{
    use ArrayTrait;
    
    protected $rowRepository;

    /**
     * @param RowsRepositoryInterface $rowRepository
     * @param array $params
     */
    public function __construct(
        RowsRepositoryInterface $rowRepository,
        ...$params
    )
    {
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * @param Entity $entity
     * @return boolean
     */
    protected function saveEntity(Entity $entity)
    {
        if (empty($postParams = Request::getPost())) {
            return false;
        }
        $errors = [];
        // сохраням
        $entity->setAttributes($postParams);
        // удалям строки
        if ($rows = $entity->getRows()) {
            foreach ($rows as $row) {
                $row->markDeleted();
            }
        }
        // сохраням строки
        $sum = 0;
        $rowsData = $this->transposeArray($postParams);
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
        if (!$entity->validate()) {
            $errors[] = $entity->getErrorsSummary();
        }
        if (!empty($errors)) {
            $this->flash->addFlash('Что то пошло не так, ' . implode("\n", $errors), Flash::FLASH_TYPE_ERROR);
            return false;
        }
        if (!$entity->getDbContext()->commit()) {
            $this->flash->addFlash('Что то пошло не так, ' . implode("\n", $entity->getErrorsSummary()), Flash::FLASH_TYPE_ERROR);
            return false;
        }
        $this->flash->addFlash('Сохранено успешно', Flash::FLASH_TYPE_SUCCESS);
        return true;
    }
}
