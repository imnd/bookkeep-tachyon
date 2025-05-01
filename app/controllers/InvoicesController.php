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
 * @author imndsu@gmail.com
 */
class InvoicesController extends HasRowsController
{
    public function index(
        Invoice $entity,
        ClientsRepository $clientRepository
    ): void {
        $this->doIndex($entity, [
            'clients' => $clientRepository->getAllSelectList(),
        ]);
    }

    public function grid(
        Invoice $entity,
        ClientsRepository $clientRepository
    ): void {
        $getQuery = $this->request->getQuery() ?: [];
        $this->display(
            'list',
            array_merge([
                'entity' => $entity,
                'items' => $this
                    ->repository
                    ->setSearchConditions($getQuery)
                    ->setSort($getQuery)
                    ->findAll(),
            ], [
                'clients' => $clientRepository->getAllSelectList(),
            ])
        );
    }

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

    public function printout(Settings $settings, int $id): void
    {
        $this->layout = 'printout';
        if (!$item = $this->repository->findByPk($id)) {
            throw new HttpException('Такой фактуры не существует', HttpException::NOT_FOUND);
        }
        $contractType = $item->getContractType();
        $contractNum  = $item->getContractNum();
        $quantitySum  = $item->getQuantitySum();
        $sender       = $settings->getRequisites('firm');
        $this->view(
            "printout/{$this->request->getGet('type')}",
            compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender')
        );
    }
}
