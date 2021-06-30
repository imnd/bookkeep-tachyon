<?php

namespace app\controllers;

use
    ErrorException,
    ReflectionException,
    app\entities\Invoice,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository,
    app\models\Settings,
    tachyon\exceptions\HttpException,
    tachyon\exceptions\ContainerException,
    tachyon\exceptions\DBALException
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
     *
     * @throws ErrorException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function index(
        Invoice $entity,
        ClientsRepository $clientRepository
    ): void
    {
        $this->doIndex($entity, [
            'clients' => $clientRepository->getAllSelectList(),
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository  $clientRepository
     *
     * @throws ContainerException
     * @throws ReflectionException
     * @throws DBALException
     */
    public function create(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository
    ): void {
        $entity = $this->repository->create();
        $entity->setAttribute('number', $this->repository->getNextNumber());
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity'       => $entity,
            'row'          => $this->rowRepository->create(false),
            'clients'      => $clientRepository->getAllSelectList('name'),
            'articlesList' => $articleRepository->getAllSelectList('name'),
            'articles'     => $articleRepository->findAllRaw(),
        ]);
    }

    public function update(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository,
        $pk
    ): void {
        $this->doUpdate($pk, [
            'clients'      => $clientRepository->getAllSelectList('name'),
            'articlesList' => $articleRepository->getAllSelectList('name'),
            'articles'     => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param Settings $settings
     * @param int      $pk
     *
     * @throws HttpException
     */
    public function printout(Settings $settings, int $pk): void
    {
        $this->layout = 'printout';
        if (!$item = $this->repository->findByPk($pk)) {
            throw new HttpException('Такой фактуры не существует', HttpException::NOT_FOUND);
        }
        $contractType = $item->getContractType();
        $contractNum  = $item->getContractNum();
        $quantitySum  = $item->getQuantitySum();
        $sender       = $settings->getRequisites('firm');
        $this->view('printout/' . $this->request->getGet('type'),
            compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender'));
    }
}
