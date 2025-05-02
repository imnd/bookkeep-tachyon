<?php

namespace app\controllers;

use tachyon\exceptions\HttpException;
use tachyon\helpers\DateTimeHelper;
use app\entities\Contract,
    app\models\Settings;
use app\repositories\{
    ArticlesRepository,
    ClientsRepository
};

/**
 * Контроллер договоров
 *
 * @author imndsu@gmail.com
 */
class ContractsController extends HasRowsController
{
    protected string $layout = 'contracts';

    /**
     * Главная страница, список договоров.
     */
    public function index(
        Contract $entity,
        ClientsRepository $clientRepository,
        string $type = null
    ): void {
        $this->doIndex($entity, [
            'type'    => $type,
            'clients' => $clientRepository->getAllSelectList(),
        ]);
    }

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
