<?php
namespace app\controllers;

use
    app\entities\Bill,
    app\repositories\BillsRepository,
    app\repositories\ClientsRepository;
use ErrorException;
use ReflectionException;
use tachyon\exceptions\ContainerException;
use tachyon\exceptions\DBALException;

/**
 * Контроллер платежей
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class BillsController extends CrudController
{
    protected string $layout = 'bills';

    /**
     * @param BillsRepository $repository
     * @param array $params
     */
    public function __construct(BillsRepository $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список платежей.
     *
     * @param Bill              $entity
     * @param ClientsRepository $clientRepository
     *
     * @throws ContainerException | ErrorException | ReflectionException
     */
    public function index(Bill $entity, ClientsRepository $clientRepository): void
    {
        $this->doIndex($entity, [
            'clients' => $clientRepository->getAllSelectList(),
            'items' => $this
                ->repository
                ->setSearchConditions($this->request->getQuery())
                ->setSort($this->request->getQuery())
                ->findAll(),
        ]);
    }

    /**
     * @param ClientsRepository $clientRepository
     *
     * @throws ErrorException | ReflectionException | ContainerException | DBALException
     */
    public function create(ClientsRepository $clientRepository): void
    {
        $entity = $this->repository->create();
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity'  => $entity,
            'clients' => $clientRepository->getAllSelectList('name'),
            'contents' => $this->repository->getSelectListFromArr($this->repository->getContentsList(), true, false),
        ]);
    }

    public function update(ClientsRepository $clientRepository, $pk): void
    {
        $entity = $this->getEntity($pk);
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('update', [
            'entity' => $entity,
            'clients' => $clientRepository->getAllSelectList(),
            'contents' => $this->repository->getSelectListFromArr($this->repository->getContentsList(), true, false),
        ]);
    }
}
