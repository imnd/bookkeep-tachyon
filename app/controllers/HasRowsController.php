<?php

namespace app\controllers;

use app\interfaces\HasRowsInterface;
use
    app\interfaces\RowsRepositoryInterface,
    tachyon\db\dataMapper\Entity,
    tachyon\components\Flash
    ;
use ReflectionException;
use tachyon\exceptions\{
    ContainerException,
    DBALException,
    HttpException,
    ValidationException
};
use tachyon\Helpers\ArrayHelper;

/**
 * base class for all controllers table
 *
 * @author imndsu@gmail.com
 */
class HasRowsController extends CrudController
{
    protected RowsRepositoryInterface $rowRepository;

    public function __construct(
        RowsRepositoryInterface $rowRepository,
        ...$params
    ) {
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
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
        $entity->deleteRows();
        // save rows
        $sum = 0;
        $rowsData = ArrayHelper::transposeArray($postParams);
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
