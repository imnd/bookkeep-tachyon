<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Article,
    app\repositories\ArticlesRepository,
    app\repositories\ArticleSubcatsRepository;

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
        $pk,
        ArticleSubcatsRepository $articleSubcatRepository,
        RegionRepository $regionRepository
    )
    {
        $this->_update($pk, [
            'regions' => $regionRepository->findAll(),
            'articleSubcats' => $articleSubcatRepository->getSelectList(),
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
