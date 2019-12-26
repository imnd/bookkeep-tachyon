<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Invoice,
    app\repositories\InvoiceRowsRepository,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository,
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
     * @param InvoiceRowsRepository $rowRepository
     * @param array $params
     */
    public function __construct(InvoiceRowsRepository $rowRepository, ...$params)
    {
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список сущностей раздела
     * @param Invoice $entity
     * @param ClientsRepository $clientRepository
     */
    public function index(Invoice $entity, ClientsRepository $clientRepository)
    {
        $this->_index($entity, [
            'clients' => $clientRepository->getSelectList()
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository $clientRepository
     */
    public function create(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository
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
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository,
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

        $type = Request::getGet('type');
        if (!$item = $this->repository->findByPk($pk)) {
            $this->error(404, 'Такой фактуры не существует');
        }

        /*if (!$item = $this->model
            ->with('rows')
            ->with('client')
            ->with('contract')
            ->findByPk($pk)
        ) {
            $this->error(404, 'Такой фактуры не существует');
        }*/
        $client = $item->client;
        $contractType = $item->getContractType();
        $contractNum = $item->contract_num;
        $quantitySum = $this->model->getQuantitySum($pk);
        $sender = $settings->getRequisites('firm');
        $this->view("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
