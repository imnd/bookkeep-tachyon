<?php
namespace app\controllers;

use
    tachyon\Request,
    app\entities\Invoice,
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

        if (!$item = $this->repository->findByPk($pk)) {
            $this->error(404, 'Такой фактуры не существует');
        }
        $contractType = $item->getContractType();
        $contractNum = $item->getContractNum();
        $quantitySum = $item->getQuantitySum();
        $sender = $settings->getRequisites('firm');
        $this->view('printout/' . Request::getGet('type'), compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender'));
    }
}
