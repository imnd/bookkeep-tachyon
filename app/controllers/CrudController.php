<?php
namespace app\controllers;

use tachyon\exceptions\HttpException,
    tachyon\Controller,
    tachyon\components\Flash,
    tachyon\db\dataMapper\Entity,
    tachyon\Request,
    tachyon\traits\AuthActions,
    app\interfaces\RepositoryInterface
;

/**
 * Базовый класс для всех контроллеров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class CrudController extends Controller
{
    use AuthActions;

    /** @inheritdoc */
    protected $layout = 'crud';
    /** @inheritdoc */
    protected $postActions = array('delete');
    /** @inheritdoc */
    protected $protectedActions = '*';

    /**
     * @var Flash
     */
    protected $flash;
    /**
     * @var RepositoryInterface
     */
    protected $repository;

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
    public function beforeAction()
    {
        if ($this->protectedActions==='*' || in_array($this->action, $this->protectedActions)) {
            $this->checkAccess();
        }
        return true;
    }

    /**
     * Главная страница, список сущностей раздела
     * 
     * @param Entity $entity
     * @param array $params
     */
    protected function _index(Entity $entity, $params = array())
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
     */
    protected function _update($pk, $params)
    {
        /**
         * @var Entity $entity
         */
        $entity = $this->getEntity($pk);
        if ($this->_save($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', array_merge(compact('entity'), $params));
    }

    /**
     * @param $params
     */
    protected function _create($params)
    {
        /**
         * @var Entity $entity
         */
        $entity = $this->repository->create();
        if ($this->_save($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', array_merge(compact('entity'), $params));
    }

    /**
     * @param Entity $entity
     * @return boolean
     */
    protected function _save(Entity $entity)
    {
        if (empty($postParams = Request::getPost())) {
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
    public function delete($pk)
    {
        echo json_encode([
            'success' => $this->getEntity($pk)->delete()
        ]);
    }

    /**
     * @param int $pk
     * @return Entity
     */
    protected function getEntity($pk)
    {
        if (!$entity = $this->repository->findByPk($pk)) {
            throw new HttpException($this->msg->i18n('Wrong address.'), HttpException::NOT_FOUND);
        }
        return $entity;
    }
}
