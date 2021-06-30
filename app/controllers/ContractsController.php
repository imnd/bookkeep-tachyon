<?php

namespace app\controllers;

use ErrorException;
use ReflectionException;
use tachyon\exceptions\{
    ContainerException,
    DBALException,
    HttpException,
};
use app\repositories\{
    ArticlesRepository,
    ClientsRepository
};
use app\entities\Contract,
    app\models\Settings;

/**
 * class ContractsController
 * Контроллер договоров
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class ContractsController extends HasRowsController
{
    protected string $layout = 'contracts';

    /**
     * Главная страница, список договоров.
     *
     * @param Contract          $entity
     * @param ClientsRepository $clientRepository
     * @param null              $type
     *
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ErrorException
     */
    public function index(
        Contract $entity,
        ClientsRepository $clientRepository,
        $type = null
    ): void {
        $this->doIndex($entity, [
            'type'    => $type,
            'clients' => $clientRepository->getAllSelectList(),
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository  $clientRepository
     * @throws ReflectionException | ContainerException | DBALException | HttpException
     */
    public function create(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository
    ): void {
        $this->doCreate([
            'clients'      => $clientRepository->getAllSelectList(),
            'articlesList' => $articleRepository->getAllSelectList(),
            'articles'     => $articleRepository->findAllRaw(),
            'row'          => $this->rowRepository->create(false),
            // Список типов для селекта на форме
            'types'        => $this->repository->getSelectListFromArr(Contract::TYPES, true),
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository  $clientRepository
     * @param int                $pk
     *
     * @throws ReflectionException | ContainerException | DBALException | HttpException
     */
    public function update(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository,
        int $pk
    ): void {
        $this->doUpdate(
            $pk,
            [
                'row' => $this->rowRepository->create(false),
                'clients' => $clientRepository->getAllSelectList(),
                'articlesList' => $articleRepository->getAllSelectList(),
                'articles' => $articleRepository->findAllRaw(),
                'types'    => $this->repository->getSelectListFromArr(Contract::TYPES, true),
            ]
        );
    }

    /**
     * @param Settings $settings
     * @param int      $pk
     *
     * @throws DBALException
     */
    public function printout(Settings $settings, int $pk): void
    {
        $this->layout = 'printout';
        /** @var Contract */
        if (!$contract = $this->repository->findByPk($pk)) {
            $this->error(404, 'Такого договора не существует');
        }
        $quantitySum = $contract->getQuantitySum($pk);
        $typeName = $contract->getTypeName($contract->getType());
        $termStart = $contract->convDateToReadable($contract->getTermStart());
        $termEnd = $contract->convDateToReadable($contract->getTermEnd());
        $term = "с $termStart по $termEnd";
        $firm = $settings->getRequisites('firm');
        $this->view('printout', compact('contract', 'quantitySum', 'typeName', 'term', 'firm'));
    }
}
