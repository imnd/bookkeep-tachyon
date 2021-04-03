<?php

namespace app\controllers;

use app\interfaces\HasRowsInterface;
use
    app\interfaces\RowsRepositoryInterface,
    tachyon\db\dataMapper\Entity,
    tachyon\components\Flash,
    tachyon\traits\ArrayTrait,
    tachyon\Request;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\HttpException;

/**
 * class Controller
 * Базовый класс для всех контроллеров таблиц
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class HasRowsController extends CrudController
{
    use ArrayTrait;

    protected RowsRepositoryInterface $rowRepository;

    /**
     * @param RowsRepositoryInterface $rowRepository
     * @param array                   $params
     */
    public function __construct(
        RowsRepositoryInterface $rowRepository,
        ...$params
    ) {
        $this->rowRepository = $rowRepository;
        parent::__construct(...$params);
    }

    /**
     * @param Entity $entity
     *
     * @return boolean
     * @throws DBALException
     */
    protected function saveEntity(Entity $entity): bool
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
            $this->flash->addFlash(
                'Что то пошло не так, ' . implode("\n", $entity->getErrorsSummary()),
                Flash::FLASH_TYPE_ERROR
            );
            return false;
        }
        $this->flash->addFlash('Сохранено успешно', Flash::FLASH_TYPE_SUCCESS);
        return true;
    }

    /**
     * @param int   $pk
     * @param array $params
     *
     * @return void
     * @throws HttpException
     * @throws DBALException
     */
    protected function doUpdate(int $pk, array $params): void
    {
        /** @var HasRowsInterface $entity */
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        if (!$rows = $entity->getRows() ?: []) {
            $row = $this->rowRepository->create(false);
        } else {
            $row = $rows[0];
        }
        $this->view('update', array_merge(compact('entity', 'rows', 'row'), $params));
    }
}
