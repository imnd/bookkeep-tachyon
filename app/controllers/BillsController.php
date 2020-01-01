<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Bill,
    app\repositories\ClientsRepository;

/**
 * Контроллер платежей
 *
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class BillsController extends CrudController
{
    protected $layout = 'bills';

    /**
     * Главная страница, список платежей.
     *
     * @param Bill $entity
     * @param ClientsRepository $clientRepository
     */
    public function index(Bill $entity, ClientsRepository $clientRepository)
    {
        $this->doIndex($entity, [
            'clients' => $clientRepository->getAllSelectList(),
            'items' => $this
                ->repository
                ->setSearchConditions(Request::getQuery())
                ->setSort(Request::getQuery())
                ->findAll(),
        ]);
    }

    public function update(
        ClientsRepository $clientRepository,
        $pk
    )
    {
        /**
         * @var Entity $entity
         */
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
