<?php
namespace app\controllers;

use app\entities\Bill,
    app\interfaces\BillRepositoryInterface,
    app\interfaces\ClientRepositoryInterface;

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
     * @var BillRepositoryInterface
     */
    protected $repository;

    /**
     * @param BillRepositoryInterface $repository
     * @param array $params
     */
    public function __construct(BillRepositoryInterface $repository, ...$params)
    {
        $this->repository = $repository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список платежей.
     * 
     * @param Bill $entity
     * @param ClientRepositoryInterface $clientRepository
     */
    public function index(Bill $entity, ClientRepositoryInterface $clientRepository)
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
