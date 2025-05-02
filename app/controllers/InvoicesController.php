<?php

namespace app\controllers;

use app\entities\Invoice;
use app\models\Settings;
use app\repositories\ArticlesRepository;
use app\repositories\ClientsRepository;
use tachyon\components\RepositoryList;
use tachyon\exceptions\HttpException;

/**
 * Контроллер фактур
 *
 * @author imndsu@gmail.com
 */
class InvoicesController extends HasRowsController
{
    private RepositoryList $clientRepositoryList;
    private RepositoryList $articleRepositoryList;

    public function __construct(
        ClientsRepository $clientRepository,
        private readonly ArticlesRepository $articleRepository,
        ...$params
    ) {
        $this->clientRepositoryList = new RepositoryList($clientRepository);
        $this->articleRepositoryList = new RepositoryList($articleRepository);

        parent::__construct(...$params);
    }

    public function index(Invoice $entity): void
    {
        $this->doIndex($entity, [
            'clients' => $this->clientRepositoryList->getAllSelectList(),
        ]);
    }

    public function grid(Invoice $entity): void
    {
        $getQuery = $this->request->getQuery() ?: [];
        $this->display(
            'list',
            array_merge([
                'entity' => $entity,
                'items'  => $this
                    ->repository
                    ->setSearchConditions($getQuery)
                    ->setSort($getQuery)
                    ->findAll(),
            ], [
                'clients' => $this->clientRepositoryList->getAllSelectList(),
            ])
        );
    }

    public function create(
    ): void {
        $entity = $this->repository->create();
        $entity->setAttribute('number', $this->repository->getNextNumber());
        if ($this->saveEntity($entity)) {
            $this->redirect("/{$this->id}");
        }
        $this->view('create', [
            'entity'       => $entity,
            'row'          => $this->rowRepository->create(false),
            'clients'      => $this->clientRepositoryList->getAllSelectList(),
            'articlesList' => $this->articleRepositoryList->getAllSelectList(),
            'articles'     => $this->articleRepository->findAllRaw(),
        ]);
    }

    public function update(
        ArticlesRepository $articleRepository,
        $pk
    ): void {
        $this->doUpdate($pk, [
            'clients'      => $this->clientRepositoryList->getAllSelectList(),
            'articlesList' => $this->articleRepositoryList->getAllSelectList(),
            'articles'     => $this->articleRepository->findAllRaw(),
        ]);
    }

    public function printout(Settings $settings, int $id): void
    {
        $this->layout = 'printout';
        if (!$item = $this->repository->findByPk($id)) {
            throw new HttpException('Такой фактуры не существует', HttpException::NOT_FOUND);
        }
        $contractType = $item->getContractType();
        $contractNum = $item->getContractNum();
        $quantitySum = $item->getQuantitySum();
        $sender = $settings->getRequisites('firm');
        $this->view(
            "printout/{$this->request->getGet('type')}",
            compact('item', 'contractType', 'contractNum', 'quantitySum', 'sender')
        );
    }
}
