<?php

namespace app\controllers;

use
    app\entities\Article,
    app\repositories\ArticleSubcatsRepository,
    app\repositories\RegionsRepository;

/**
 * Контроллер товаров
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ArticlesController extends CrudController
{
    /**
     * Главная страница, список товаров.
     *
     * @param Article $entity
     */
    public function index(Article $entity)
    {
        $this->doIndex($entity);
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository $regionsRepository
     * @param int $pk
     */
    public function update(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository,
        $pk
    ) {
        $this->doUpdate($pk, $this->_vars($articleSubcatsRepository, $regionsRepository));
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository $regionsRepository
     */
    public function create(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository
    ) {
        $this->doCreate($this->_vars($articleSubcatsRepository, $regionsRepository));
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository $regionsRepository
     * @return array
     */
    private function _vars(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository
    ): array {
        return [
            'articleSubcats' => $articleSubcatsRepository->getAllSelectList(),
            'units' => $this->repository->getSelectListFromArr($this->repository->getUnits()),
            'regions' => $regionsRepository->findAll(),
        ];
    }

}
