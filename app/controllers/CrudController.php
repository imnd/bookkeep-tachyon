<?php
namespace app\controllers;

use
    tachyon\exceptions\HttpException,
    tachyon\Controller,
    tachyon\components\Flash,
    tachyon\db\dataMapper\Entity,
    tachyon\traits\Auth,
    tachyon\db\dataMapper\EntityInterface,
    tachyon\Request,
    tachyon\db\dataMapper\RepositoryInterface;

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
    protected $postActions = array('delete');
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
     * Хук, срабатывающий перед запуском экшна
     * @return boolean
     */
    public function beforeAction(): bool
    {
        if ($this->protectedActions==='*' || in_array($this->action, $this->protectedActions)) {
            return $this->checkAccess();
        }
        return true;
    }

    /**
     * Главная страница, список сущностей раздела
     *
     * @param EntityInterface $entity
     * @param array $params
     * @return void
     */
    protected function doIndex(Entity $entity, $params = array()): void
    {
        $getQuery = Request::getQuery();
        $this->view('index', array_merge([
            'entity' => $entity,
            'items' => $this
                ->repository
                ->setSearchConditions($getQuery)
                ->setSort($getQuery)
                ->findAll(),
        ], $params));
    }

    /**
     * @param int $pk
     * @param array $params
     * @return void
     */
    protected function doUpdate($pk, $params): void
    {
        /** @var Entity $entity */
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', array_merge(compact('entity'), $params));
    }

    /**
     * @param $params
     * @return void
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
     * @return boolean
     */
    protected function saveEntity(Entity $entity): bool
    {
        if (!empty($postParams = Request::getPost())) {
            $entity->setAttributes($postParams);
            if ($entity->save()) {
                $this->flash->setFlash('Сохранено успешно', Flash::FLASH_TYPE_SUCCESS);
                return true;
            }
            $this->flash->setFlash("Что то пошло не так, {$entity->getErrorsSummary()}", Flash::FLASH_TYPE_ERROR);
        }
        return false;
    }

    /**
     * @param int $pk
     */
    public function delete($pk): void
    {
        echo json_encode([
            'success' => $this->getEntity($pk)->delete()
        ]);
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
