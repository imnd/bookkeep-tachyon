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
        $this->view('index', [
            'entity' => $entity,
            'clients' => $clientRepository->getSelectList(),
            'items' => $this
                ->repository
                ->setSearchConditions(Request::getQuery())
                ->setSort(Request::getQuery())
                ->findAll(),
        ]);
    }
}
