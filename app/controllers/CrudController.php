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
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
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

    /**
     * @var Flash
     */
    protected Flash $flash;

    /**
     * @var RepositoryInterface
     */
    protected RepositoryInterface $repository;

    public function __construct(RepositoryInterface $repository, Flash $flash, ...$params)
    {
        $this->repository = $repository;
        $this->flash = $flash;
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
     *
     * @param EntityInterface $entity
     * @param array           $params
     *
     * @return void
     * @throws ErrorException
     */
    protected function doIndex(EntityInterface $entity, $params = []): void
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

    /**
     * @param int   $pk
     * @param array $params
     *
     * @return void
     * @throws DBALException
     * @throws HttpException
     */
    protected function doUpdate(int $pk, array $params): void
    {
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', array_merge(compact('entity'), $params));
    }

    /**
     * @param $params
     *
     * @return void
     * @throws DBALException
     */
    protected function doCreate($params): void
    {
        /** @var Entity $entity */
        $entity = $this->repository->create();
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', array_merge(compact('entity'), $params));
    }

    /**
     * @param Entity $entity
     *
     * @return boolean
     * @throws DBALException
     */
    protected function saveEntity(Entity $entity): bool
    {
        if (!$postParams = $this->request->getPost()) {
            return false;
        }
        $entity->setAttributes($postParams);
        if (!$entity->validate()) {
            $this->flash->addFlash(
                'Ошибка валидации: ' . $entity->getErrorsSummary(),
                Flash::FLASH_TYPE_ERROR
            );
            return false;
        }
        if (!$entity->getDbContext()->commit()) {
            $this->flash->addFlash(
                'Что то пошло не так.',
                Flash::FLASH_TYPE_ERROR
            );
            return false;
        }
        return true;
    }

    /**
     * @param int $pk
     *
     * @throws HttpException | JsonException
     */
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
     *
     * @param mixed $pk
     *
     * @return Entity
     * @throws HttpException
     */
    protected function getEntity($pk): Entity
    {
        if (!$entity = $this->repository->findByPk($pk)) {
            throw new HttpException($this->msg->i18n('Wrong address.'), HttpException::NOT_FOUND);
        }
        return $entity;
    }
}
