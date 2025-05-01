<?php

namespace app\controllers;

use ErrorException;
use JsonException;
use tachyon\exceptions\DBALException;
use
    tachyon\exceptions\HttpException,
    tachyon\Controller,
    tachyon\components\Flash,
    tachyon\db\dataMapper\Entity,
    tachyon\db\dataMapper\EntityInterface,
    tachyon\db\dataMapper\RepositoryInterface,
    tachyon\traits\Auth;

/**
 * Базовый класс для всех контроллеров
 *
 * @author imndsu@gmail.com
 */
class CrudController extends Controller
{
    use Auth;

    /** @inheritdoc */
    protected string $layout = 'crud';
    /** @inheritdoc */
    protected $postActions = ['delete'];
    /** @inheritdoc */
    protected $protectedActions = '*';

    public function __construct(
        protected RepositoryInterface $repository,
        protected Flash $flash,
        ...$params
    ) {
        parent::__construct(...$params);
    }

    /**
     * @inheritDoc
     */
    public function beforeAction(): bool
    {
        if ($this->protectedActions === '*' || in_array($this->action, $this->protectedActions)) {
            return $this->checkAccess();
        }
        return true;
    }

    /**
     * Главная страница, список сущностей раздела
     */
    protected function doIndex(EntityInterface $entity, array $params = []): void
    {
        $getQuery = $this->request->getQuery() ?: [];
        $this->view(
            'index',
            array_merge(
                [
                    'entity' => $entity,
                    'items' => $this
                        ->repository
                        ->setSearchConditions($getQuery)
                        ->setSort($getQuery)
                        ->findAll(),
                ],
                $params
            )
        );
    }

    protected function doUpdate(int $pk, array $params): void
    {
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', array_merge(compact('entity'), $params));
    }

    protected function doCreate(array $params): void
    {
        /** @var Entity $entity */
        $entity = $this->repository->create();
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', array_merge(compact('entity'), $params));
    }

    protected function saveEntity(Entity $entity): bool
    {
        if (!$postParams = $this->request->getPost()) {
            return false;
        }
        $entity->setAttributes($postParams);
        if (!$entity->validate()) {
            flash(
                'Ошибка валидации: ' . $entity->getErrorsSummary(),
                Flash::FLASH_TYPE_ERROR
            );
            return false;
        }
        if (!$entity->getDbContext()->commit()) {
            flash(
                'Что то пошло не так.',
                Flash::FLASH_TYPE_ERROR
            );
            return false;
        }
        return true;
    }

    public function delete(int $pk): void
    {
        echo json_encode(
            [
                'success' => $this->getEntity($pk)->delete(),
            ],
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * Извлекает запись по первичному ключу $pk
     */
    protected function getEntity(mixed $pk): Entity
    {
        if (!$entity = $this->repository->findByPk($pk)) {
            throw new HttpException(t('Wrong address.'), HttpException::NOT_FOUND);
        }
        return $entity;
    }
}
