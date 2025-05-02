<?php

namespace app\controllers;

use
    app\entities\Purchase,
    app\models\Settings,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository;
use tachyon\components\RepositoryList;

/**
 * Контроллер закупок
 *
 * @author imndsu@gmail.com
 */
class PurchasesController extends HasRowsController
{
    private RepositoryList $clientRepositoryList;
    private RepositoryList $articleRepositoryList;

    public function __construct(
        ClientsRepository $clientRepository,
        private readonly ArticlesRepository $articleRepository,
        ...$params
    ) {
        $this->clientRepositoryList = new RepositoryList($clientRepository);
        $this->articleRepositoryList = new RepositoryList($articleRepository);

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список договоров.
     */
    public function index(
        Purchase $entity,
        $type = null
    ): void {
        $this->doIndex($entity, [
            'type' => $type,
            'clients' => $this->clientRepositoryList->getAllSelectList()
        ]);
    }

    /**
     * Собираем закупку за определенное число
     */
    public function create(): void
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $entity = $this->repository->create();
        $entity->setDate($date);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $row = $this->rowRepository->create(false);

        $this->view('create', [
            'entity' => $entity,
            'row' => $row,
            'date' => $date,
            'clients' => $this->clientRepositoryList->getAllSelectList(),
            'articlesList' => $this->articleRepositoryList->getAllSelectList(),
            'articles' => $this->articleRepository->findAllRaw(),
        ]);
    }

    public function update(int $pk): void
    {
        $this->doUpdate($pk, [
            'row' => $this->rowRepository->create(false),
            'clients' => $this->clientRepositoryList->getAllSelectList(),
            'articlesList' => $this->articleRepositoryList->getAllSelectList(),
            'articles' => $this->articleRepository->findAllRaw(),
        ]);
    }

    public function printout(Settings $settings, int $pk): void
    {
        $this->layout = 'printout';
        $item = $this->model
            ->with('rows')
            ->findByPk($pk);

        $this->display('printout', [
            'item'         => $item,
            'contractType' => 'Договор',
            'quantitySum'  => $this->model->getQuantitySum($pk),
            'sender'       => $settings->getRequisites('supplier'),
            'client'       => $settings->getRequisites('firm'),
        ]);
    }
}
