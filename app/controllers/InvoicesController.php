<?php
namespace app\controllers;

use app\entities\Invoice,
    app\repositories\InvoiceRepository,
    app\repositories\InvoiceRowRepository,
    app\repositories\ArticleRepository,
    app\repositories\ClientRepository,
    app\models\Settings;

/**
 * Контроллер фактур
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class InvoicesController extends HasRowsController
{
    /**
     * @param InvoiceRepository $repository
     * @param InvoiceRowRepository $rowRepository
     * @param array $params
     */
    public function __construct(
        InvoiceRepository $repository,
        InvoiceRowRepository $rowRepository,
        ...$params
    )
    {
        $this->repository = $repository;
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список сущностей раздела
     * @param Invoice $entity
     * @param ClientRepository $clientRepository
     */
    public function index(
        Invoice $entity,
        ClientRepository $clientRepository
    )
    {
        $this->_index($entity, [
            'clients' => $clientRepository->getSelectList()
        ]);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param ClientRepository $clientRepository
     */
    public function create(
        ArticleRepository $articleRepository,
        ClientRepository $clientRepository
    )
    {
        $entity = $this->repository->create();
        $entity->setAttribute('number', $this->repository->getNextNumber());
        if ($this->save($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity' => $entity,
            'row' => $this->rowRepository->create(false),
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    public function update(
        ArticleRepository $articleRepository,
        ClientRepository $clientRepository,
        $pk
    )
    {
        $this->_update($pk, [
            'row' => $this->rowRepository->create(false),
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param Settings $settings
     * @param int $pk
     */
    public function printout(Settings $settings, $pk)
    {
        $this->layout = 'printout';

        $type = $this->get['type'];
        $item = $this->repository
            //->with('rows')
            //->with('client')
            //->with('contract')
            ->findByPk($pk);
        
        if (!$item = $this->model
            ->with('rows')
            ->with('client')
            ->with('contract')
            ->findByPk($pk)
        ) {
            $this->error(404, 'Такой фактуры не существует');
        }
        $client = $item->client;
        $contractType = $item->getContractType();
        $contractNum = $item->contract_num;
        $quantitySum = $this->model->getQuantitySum($pk);
        $sender = $settings->getRequisites('firm');
        $this->view("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
