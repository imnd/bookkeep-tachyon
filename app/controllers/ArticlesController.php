<?php

namespace app\controllers;

use app\entities\Article;
use app\repositories\ArticleRepository;
use app\repositories\ArticleSubcatRepository;
use app\repositories\RegionRepository;
use tachyon\traits\Authentication;

/**
 * Контроллер товаров
 *
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class ArticlesController extends CrudController
{
    use Authentication;

    /**
     * @var ArticleRepository
     */
    protected $repository;
    /**
     * @var ArticleSubcatRepository
     */
    protected $subcatRepository;

    /**
     * @param ArticleRepository $repository
     * @param array             $params
     */
    public function __construct(ArticleRepository $repository, ...$params)
    {
        $this->repository = $repository;
        parent::__construct(...$params);
    }

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
        ArticleSubcatRepository $articleSubcatRepository,
        RegionRepository $regionRepository
    ) {
        $this->_update($pk, [
            'regions'        => $regionRepository->findAll(),
            'articleSubcats' => $articleSubcatRepository->getSelectList(),
        ]);
    }

    /**
     * @param $params
     */
    protected function create()
    {
        $this->_create();
    }
}
