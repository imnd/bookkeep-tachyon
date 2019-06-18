<?php
namespace app\controllers;

use app\entities\Contract,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
    app\interfaces\ContractRowRepositoryInterface,
    app\interfaces\ContractRepositoryInterface
;

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
     * @param ContractRepositoryInterface $repository
     * @param ContractRowRepositoryInterface $rowRepository
     * @param array $params
     */
    public function __construct(
        ContractRepositoryInterface $repository,
        ContractRowRepositoryInterface $rowRepository,
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
     * @param Contract $entity
     * @param ClientRepositoryInterface $clientRepository
     * @param string $type
     */
    public function index(
        Contract $entity,
        ClientRepositoryInterface $clientRepository,
        $type = null
    )
    {
        $this->_index($entity, [
            'type' => $type,
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
     * @param ArticleRepositoryInterface $articleRepository
     * @param ClientRepositoryInterface $clientRepository
     * @param int $pk
     */
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
