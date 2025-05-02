<?php
namespace app\controllers;

use
    app\entities\Bill,
    app\repositories\BillsRepository,
    app\repositories\ClientsRepository,
    tachyon\components\RepositoryList;

/**
 * Контроллер платежей
 *
 * @author imndsu@gmail.com
 */
class BillsController extends CrudController
{
    protected string $layout = 'bills';
    private RepositoryList $clientRepositoryList;
    private RepositoryList $repositoryList;

    public function __construct(
        BillsRepository $repository,
        protected ClientsRepository $clientRepository,
        ...$params
    ) {
        $this->repository = $repository;
        $this->repositoryList = new RepositoryList($repository);
        $this->clientRepositoryList = new RepositoryList($clientRepository);

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список платежей.
     */
    public function index(Bill $entity): void
    {
        $this->doIndex($entity, [
            'clients' => $this->clientRepositoryList->getAllSelectList(),
            'items' => $this
                ->repository
                ->setSearchConditions($this->request->getQuery())
                ->setSort($this->request->getQuery())
                ->findAll(),
        ]);
    }

    public function create(): void
    {
        $entity = $this->repository->create();
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity'  => $entity,
            'clients' => $this->clientRepositoryList->getAllSelectList(),
            'contents' => $this->repositoryList->getSelectListFromArr($this->repository->getContentsList(), true, false),
        ]);
    }

    public function update($pk): void
    {
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', [
            'entity' => $entity,
            'clients' => $this->clientRepositoryList->getAllSelectList(),
            'contents' => $this->repositoryList->getSelectListFromArr($this->repository->getContentsList(), true, false),
        ]);
    }
}
