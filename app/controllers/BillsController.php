<?php
namespace app\controllers;

use app\entities\Bill;
use app\repositories\BillRepository;
use app\repositories\ClientRepository;

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
     * @param ClientRepository $clientRepository
     */
    public function index(Bill $entity, ClientRepository $clientRepository)
    {
        $this->view('index', [
            'entity' => $entity,
            'clients' => $clientRepository->getSelectList(),
            'items' => $this
                ->repository
                ->setSearchConditions($this->get)
                ->setSort($this->get)
                ->findAll(),
        ]);
    }
}
