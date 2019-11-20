<?php
namespace app\controllers;

use app\entities\Purchase,
    app\repositories\ArticleRepository,
    app\repositories\ClientRepository,
    app\repositories\PurchaseRowRepository,
    app\repositories\PurchaseRepository
;

/**
 * Контроллер закупок
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class PurchasesController extends HasRowsController
{
    /**
     * @param PurchaseRepository $repository
     * @param PurchaseRowRepository $rowRepository
     * @param array $params
     */
    public function __construct(
        PurchaseRepository $repository,
        PurchaseRowRepository $rowRepository,
        ...$params
    )
    {
        $this->repository = $repository;
        $this->rowRepository = $rowRepository;

        parent::__construct(...$params);
    }

    /**
     * Главная страница, список договоров.
     *
     * @param Purchase $entity
     * @param ClientRepository $clientRepository
     * @param null $type
     */
    public function index(
        Purchase $entity,
        ClientRepository $clientRepository,
        $type = null
    )
    {
        $this->_index($entity, [
            'type' => $type,
            'clients' => $clientRepository->getSelectList()
        ]);
    }

    /**
     * Собираем закупку за определенное число
     * @param ArticleRepository $articleRepository
     * @param ClientRepository $clientRepository
     */
    public function create(
        ArticleRepository $articleRepository,
        ClientRepository $clientRepository
    )
    {
        $entity = $this->repository->create();
        $entity->setDate($this->get['date'] ?? date('Y-m-d'));
        if ($this->save($entity)) {
            $this->redirect("/{$this->id}");
        }
        $row = $this->rowRepository->create(false);
        $this->view('create', [
            'entity' => $entity,
            'row' => $row,
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param ArticleRepository $articleRepository
     * @param ClientRepository $clientRepository
     * @param int $pk
     */
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

        $item = $this->model
            ->with('rows')
            ->findByPk($pk);

        $this->display('printout', array(
            'item' => $item,
            'contractType' => 'Договор',
            'quantitySum' => $this->model->getQuantitySum($pk),
            'sender' => $settings->getRequisites('supplier'),
            'client' => (object)$settings->getRequisites('firm'),
        ));
    }
}
