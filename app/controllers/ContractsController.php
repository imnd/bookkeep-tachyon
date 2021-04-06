<?php

namespace app\controllers;

use app\repositories\{
    ArticlesRepository,
    ClientsRepository,
    ContractsRepository,
    ContractsRowsRepository,
};
use app\entities\Contract,
    app\models\Settings;
use ReflectionException;
use tachyon\exceptions\ContainerException;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\HttpException;

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
     * @param ContractsRepository     $repository
     * @param ContractsRowsRepository $rowRepository
     * @param array                   $params
     */
    public function __construct(
        ContractsRepository $repository,
        ContractsRowsRepository $rowRepository,
        ...$params
    ) {
        $this->repository = $repository;
        $this->rowRepository = $rowRepository;
        parent::__construct(...$params);
    }

    /**
     * Главная страница, список договоров.
     *
     * @param Contract          $entity
     * @param ClientsRepository $clientRepository
     * @param string            $type
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
        $row = $this->rowRepository->create();
        $this->doCreate([
            'clients'      => $clientRepository->getAllSelectList(),
            'articlesList' => $articleRepository->getAllSelectList(),
            'articles'     => $articleRepository->findAllRaw(),
            'row'          => $row,
            'rows'         => [$row],
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
            $this->error(404, 'Такой фактуры не существует');
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
