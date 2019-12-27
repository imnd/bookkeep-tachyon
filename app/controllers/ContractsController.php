<?php
namespace app\controllers;

use app\entities\Contract,
    app\repositories\ArticlesRepository,
    app\repositories\ClientsRepository;

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
        $this->_index($entity, [
            'type' => $type,
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
        $row = $this->rowRepository->create();
        $this->_create([
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
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
        $this->_update($pk, [
            'row' => $this->rowRepository->create(false),
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
        ]);
    }

    /**
     * @param Settings $settings
     * @param ContractsRows $contractsRows
     * @param int $pk
     */
    public function printout(Settings $settings, ContractsRows $contractsRows, $pk)
    {
        $this->layout = 'printout';

        $contract = $this->model
            ->with('client')
            ->findByPk($pk);

        $quantitySum = $this->model->getQuantitySum($pk);
        $typeName = $this->model->getTypeName($contract->type);

        $termStart = $contract->convDateToReadable($contract->term_start);
        $termEnd = $contract->convDateToReadable($contract->term_end);
        $term = "с $termStart по $termEnd";
        $rows = $contractsRows->getAllByContract($pk);
        $firm = $settings->getRequisites('firm');
        $this->view('printout', compact('contract', 'rows', 'quantitySum', 'typeName', 'term', 'firm'));
    }

    public function getItem($num)
    {
        echo json_encode($this->model->getItem(compact('num')));
    }
}
