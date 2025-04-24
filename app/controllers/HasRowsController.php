<?php

namespace app\controllers;

use app\interfaces\HasRowsInterface;
use
    app\interfaces\RowsRepositoryInterface,
    tachyon\db\dataMapper\Entity,
    tachyon\components\Flash,
    tachyon\traits\ArrayTrait;
use ReflectionException;
use tachyon\exceptions\ContainerException;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\HttpException;
use tachyon\exceptions\ValidationException;

/**
 * Базовый класс для всех контроллеров таблиц
 *
 * @author imndsu@gmail.com
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
     * @throws ReflectionException
     * @throws ContainerException
     * @throws ValidationException
     */
    protected function saveEntity(Entity $entity): bool
    {
        if (!$postParams = $this->request->getPost()) {
            return false;
        }
        $entity->setAttributes($postParams);
        if (!$entity->validate()) {
            flash("Ошибка. {$entity->getErrorsSummary()}", Flash::FLASH_TYPE_ERROR);
            return false;
        }
        // удаляем строки
        $entity->deleteRows();
        // сохраняем строки
        $sum = 0;
        $rowsData = $this->transposeArray($postParams);
        $rows = [];
        $errors = [];
        foreach ($rowsData as $rowData) {
            $row = $this->rowRepository->create();
            $rowData[$row->getRowFk()] = $entity->getPk();
            $row->setAttributes($rowData);
            if (!$row->validate()) {
                $errors[] = $row->getErrorsSummary();
                unset($row);
            } else {
                $rows[] = $row;
            }
            $sum += $rowData['row_sum'];
        }
        // сохраняем
        $entity->setSum($sum);
        if (!empty($errors)) {
            flash('Ошибка. ' . implode("\n", $errors), Flash::FLASH_TYPE_ERROR);
            return false;
        }

        // сохраняем
        if (!$entity->getDbContext()->saveEntity($entity)) {
            flash('Ошибка.', Flash::FLASH_TYPE_ERROR);
            return false;
        }
        foreach ($rows as $index => $row) {
            $row->setRowFkProp($entity->getPk());
        }
        $row->getDbContext()->commit();

        flash('Сохранено успешно', Flash::FLASH_TYPE_SUCCESS);

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
