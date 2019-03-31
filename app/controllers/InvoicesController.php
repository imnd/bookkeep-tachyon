<?php
namespace app\controllers;

use tachyon\db\dataMapper\Entity,
    tachyon\components\Flash,
    app\entities\Invoice,
    app\interfaces\InvoiceRepositoryInterface,
    app\interfaces\InvoiceRowRepositoryInterface,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
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
     * @param InvoiceRepositoryInterface $repository
     * @param array $params
     */
    public function __construct(
        InvoiceRepositoryInterface $repository,
        InvoiceRowRepositoryInterface $rowRepository,
        ...$params
    )
    {
        $this->repository = $repository;
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список сущностей раздела
     */
    public function index(
        Invoice $entity,
        ClientRepositoryInterface $clientRepository
    )
    {
        $this->_index($entity, [
            'clients' => $clientRepository->getSelectList()
        ]);
    }

    /**
     * @param ArticleRepositoryInterface $articleRepository
     * @param ClientRepositoryInterface $clientRepository
     */
    public function create(
        ArticleRepositoryInterface $articleRepository,
        ClientRepositoryInterface $clientRepository
    )
    {
        /**
         * @var Entity $entity
         */
        $entity = $this->repository->create();
        $entity->setAttribute('number', $this->repository->getNextNumber());
        if ($this->save($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->layout('create', [
            'entity' => $entity,
            'row' => $this->rowRepository->create(false),
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    public function update(
        ArticleRepositoryInterface $articleRepository,
        ClientRepositoryInterface $clientRepository,
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
        $this->layout("printout/$type", compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender', 'client'));
    }
}
