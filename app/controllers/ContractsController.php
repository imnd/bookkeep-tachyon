<?php
namespace app\controllers;

use app\entities\Contract,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository,
    app\models\Settings;

/**
 * class Index
 * Контроллер
 *
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class ContractsController extends HasRowsController
{
    protected $layout = 'contracts';

    /**
     * Главная страница, список договоров.
     *
     * @param Contract $entity
     * @param ClientsRepository $clientRepository
     * @param string $type
     */
    public function index(
        Contract $entity,
        ClientsRepository $clientRepository,
        $type = null
    )
    {
        $this->doIndex($entity, [
            'type' => $type,
            'clients' => $clientRepository->getAllSelectList()
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
        $row = $this->rowRepository->create();
        $this->doCreate([
            'clients' => $clientRepository->getAllSelectList(),
            'articlesList' => $articleRepository->getAllSelectList(),
            'articles' => $articleRepository->findAllRaw(),
            'row' => $row,
            'rows' => array($row),
        ]);
    }

    /**
     * @param ArticlesRepository $articleRepository
     * @param ClientsRepository $clientRepository
     * @param int $pk
     */
    public function update(
        ArticlesRepository $articleRepository,
        ClientsRepository $clientRepository,
        $pk
    )
    {
        $this->doUpdate($pk, [
            'row' => $this->rowRepository->create(false),
            'clients' => $clientRepository->getAllSelectList(),
            'articlesList' => $articleRepository->getAllSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param Settings $settings
     * @param ContractsRowsRepository $contractsRows
     * @param int $pk
     */
    public function printout(Settings $settings, $pk)
    {
        $this->layout = 'printout';

        /** @var Contract */
        if (!$contract = $this->repository->findByPk($pk)) {
            $this->error(404, 'Такой фактуры не существует');
        }

        $quantitySum = $contract->getQuantitySum($pk);
        $typeName = $contract->getTypeName($contract->getType());

        $termStart = $contract->convDateToReadable($contract->getTermStart());
        $termEnd = $contract->convDateToReadable($contract->getTermEnd());
        $term = "с $termStart по $termEnd";
        $firm = $settings->getRequisites('firm');
        $this->view('printout', compact('contract', 'quantitySum', 'typeName', 'term', 'firm'));
    }

    public function getItem($num)
    {
        echo json_encode($this->model->getItem(compact('num')));
    }
}
