<?php
namespace app\controllers;

use app\entities\Article,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ArticleSubcatRepositoryInterface;

/**
 * Контроллер товаров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */ 
class ArticlesController extends CrudController
{
    use \tachyon\traits\Authentication;

    /**
     * @var ArticleRepositoryInterface
     */
    protected $repository;
    /**
     * @var ArticleSubcatRepositoryInterface
     */
    protected $subcatRepository;

    /**
     * @param ArticleRepositoryInterface $repository
     * @param array $params
     */
    public function __construct(ArticleRepositoryInterface $repository, ...$params)
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
        ArticleSubcatRepositoryInterface $articleSubcatRepository,
        RegionRepositoryInterface $regionRepository
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
