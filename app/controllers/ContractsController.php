<?php

namespace app\controllers;

use app\entities\Contract;
use app\models\Settings;
use app\repositories\{ArticlesRepository, ClientsRepository};
use tachyon\components\RepositoryList;
use tachyon\exceptions\HttpException;
use tachyon\helpers\DateTimeHelper;

/**
 * Контроллер договоров
 *
 * @author imndsu@gmail.com
 */
class ContractsController extends HasRowsController
{
    protected string $layout = 'contracts';
    private RepositoryList $repositoryList;
    private RepositoryList $clientRepositoryList;
    private RepositoryList $articleRepositoryList;

    public function __construct(
        ClientsRepository $clientRepository,
        private ArticlesRepository $articleRepository,
        ...$params
    ) {
        $this->repositoryList = new RepositoryList($this->repository);
        $this->clientRepositoryList = new RepositoryList($clientRepository);
        $this->articleRepositoryList = new RepositoryList($articleRepository);

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список договоров.
     */
    public function index(
        Contract $entity,
        string $type = null
    ): void {
        $this->doIndex($entity, [
            'type'    => $type,
            'clients' => $this->clientRepositoryList->getAllSelectList(),
        ]);
    }

    public function create(): void
    {
        $this->doCreate([
            'clients'      => $this->clientRepositoryList->getAllSelectList(),
            'articlesList' => $this->articleRepositoryList->getAllSelectList(),
            'articles'     => $this->articleRepository->findAllRaw(),
            'row'          => $this->rowRepository->create(false),
            // Список типов для селекта на форме
            'types'        => $this->repositoryList->getSelectListFromArr(Contract::TYPES, true),
        ]);
    }

    public function update(int $pk): void
    {
        $this->doUpdate(
            $pk,
            [
                'row'          => $this->rowRepository->create(false),
                'clients'      => $this->clientRepositoryList->getAllSelectList(),
                'articlesList' => $this->articleRepositoryList->getAllSelectList(),
                'articles'     => $this->articleRepository->findAllRaw(),
                'types'        => $this->repositoryList->getSelectListFromArr(Contract::TYPES, true),
            ]
        );
    }

    public function printout(Settings $settings, int $pk): void
    {
        $this->layout = 'printout';
        /** @var Contract */
        if (!$contract = $this->repository->findByPk($pk)) {
            throw new HttpException(404, 'Такого договора не существует');
        }
        $quantitySum = $contract->getQuantitySum($pk);
        $typeName = $contract->getTypeName($contract->getType());
        $termStart = DateTimeHelper::convDateToReadable($contract->getTermStart());
        $termEnd = DateTimeHelper::convDateToReadable($contract->getTermEnd());
        $term = "с $termStart по $termEnd";
        $firm = $settings->getRequisites('firm');
        $this->view('printout', compact('contract', 'quantitySum', 'typeName', 'term', 'firm'));
    }
}
