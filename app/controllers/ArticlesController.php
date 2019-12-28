<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Article,
    app\repositories\ArticleSubcatsRepository,
    app\repositories\RegionsRepository
;

/**
 * Контроллер товаров
 *
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ArticlesController extends CrudController
{
    /**
     * @var ArticleSubcatsRepository
     */
    protected $subcatRepository;

    /**
     * Главная страница, список товаров.
     *
     * @param Article $entity
     */
    public function index(Article $entity)
    {
        $this->_index($entity);
    }

    /**
     * @param int $pk
     */
    public function update(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository,
        $pk
    )
    {
        $this->_update($pk, [
            'articleSubcats' => $articleSubcatsRepository->getAllSelectList(),
            'regions' => $regionsRepository->findAll(),
            'units' => $this->repository->getSelectListFromArr($this->repository->getUnits()),
        ]);
    }

    /**
     * @param $params
     */
    protected function create()
    {
        $this->_create($pk, [
            'regions' => $regionRepository->findAll(),
        ]);
    }
}
