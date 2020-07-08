<?php
namespace app\controllers;

use app\entities\Bill;
use app\repositories\BillsRepository;
use app\repositories\ClientsRepository;
use tachyon\db\dataMapper\Entity;
use tachyon\Request;

/**
 * Контроллер платежей
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class BillsController extends CrudController
{
    protected $layout = 'bills';
    /**
     * @var BillRepository
     */
    protected $repository;

    /**
     * @param BillRepository $repository
     * @param array $params
     */
    public function __construct(BillRepository $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

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
