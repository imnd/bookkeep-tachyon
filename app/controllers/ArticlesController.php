<?php

namespace app\controllers;

use
    app\entities\Article,
    app\repositories\ArticleSubcatsRepository,
    app\repositories\RegionsRepository,
    tachyon\components\RepositoryList;

/**
 * Контроллер товаров
 *
 * @author imndsu@gmail.com
 */
class ArticlesController extends CrudController
{
    /**
     * Главная страница, список товаров.
     */
    public function index(Article $entity): void
    {
        $this->doIndex($entity);
    }

    public function update(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository,
        int $pk
    ): void {
        $this->doUpdate($pk, $this->getFormParameters($articleSubcatsRepository, $regionsRepository));
    }

    public function create(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository
    ): void {
        $this->doCreate($this->getFormParameters($articleSubcatsRepository, $regionsRepository));
    }

    private function getFormParameters(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository
    ): array {
        $articleSubcatsRepositoryList = new RepositoryList($articleSubcatsRepository);
        $articlesRepositoryList = new RepositoryList($this->repository);
        return [
            'articleSubcats' => $articleSubcatsRepositoryList->getAllSelectList(),
            'units' => $articlesRepositoryList->getSelectListFromArr($this->repository->getUnits()),
            'regions' => $regionsRepository->findAll(),
        ];
    }
}
