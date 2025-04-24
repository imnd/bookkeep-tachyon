<?php

namespace app\controllers;

use
    app\entities\Article,
    app\repositories\ArticleSubcatsRepository,
    app\repositories\RegionsRepository;
use ErrorException;
use ReflectionException;
use tachyon\exceptions\ContainerException;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\HttpException;

/**
 * Контроллер товаров
 *
 * @author imndsu@gmail.com
 */
class ArticlesController extends CrudController
{
    /**
     * Главная страница, список товаров.
     *
     * @param Article $entity
     *
     * @throws ErrorException
     */
    public function index(Article $entity): void
    {
        $this->doIndex($entity);
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository        $regionsRepository
     * @param int                      $pk
     *
     * @throws HttpException
     */
    public function update(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository,
        int $pk
    ): void {
        $this->doUpdate($pk, $this->_vars($articleSubcatsRepository, $regionsRepository));
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository        $regionsRepository
     *
     * @throws ContainerException
     * @throws DBALException
     * @throws ReflectionException
     */
    public function create(
        ArticleSubcatsRepository $articleSubcatsRepository,
        RegionsRepository $regionsRepository
    ): void {
        $this->doCreate($this->_vars($articleSubcatsRepository, $regionsRepository));
    }

    /**
     * @param ArticleSubcatsRepository $articleSubcatsRepository
     * @param RegionsRepository        $regionsRepository
     *
     * @return array
     * @throws ContainerException
     * @throws ReflectionException
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
