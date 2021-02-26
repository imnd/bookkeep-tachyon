<?php

namespace app\controllers;

use
    app\entities\Invoice,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository,
    app\models\Settings,
    tachyon\exceptions\HttpException,
    tachyon\Request
;

/**
 * Контроллер фактур
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class InvoicesController extends HasRowsController
{
    /**
     * Главная страница, список сущностей раздела
     *
     * @param Invoice           $entity
     * @param ClientsRepository $clientRepository
     */
    public function index(Invoice $entity, ClientsRepository $clientRepository)
    {
        $this->doIndex($entity, [
            'clients' => $clientRepository->getAllSelectList(),
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository  $clientRepository
     */
    public function create(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository
    ) {
        $entity = $this->repository->create();
        $entity->setAttribute('number', $this->repository->getNextNumber());
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity'       => $entity,
            'row'          => $this->rowRepository->create(),
            'clients'      => $clientRepository->getAllSelectList('name'),
            'articlesList' => $articleRepository->getAllSelectList('name'),
            'articles'     => $articleRepository->findAllRaw(),
        ]);
    }

    public function update(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository,
        $pk
    ) {
        $this->doUpdate($pk, [
            'clients'      => $clientRepository->getAllSelectList('name'),
            'articlesList' => $articleRepository->getAllSelectList('name'),
            'articles'     => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param Settings $settings
     * @param int      $pk
     */
    public function printout(Settings $settings, $pk)
    {
        $this->layout = 'printout';
        if (!$item = $this->repository->findByPk($pk)) {
            throw new HttpException('Такой фактуры не существует', HttpException::NOT_FOUND);
        }
        $contractType = $item->getContractType();
        $contractNum  = $item->getContractNum();
        $quantitySum  = $item->getQuantitySum();
        $sender       = $settings->getRequisites('firm');
        $this->view('printout/' . Request::getGet('type'),
            compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender'));
    }
}
