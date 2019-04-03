<?php
namespace app\controllers;

use tachyon\db\dataMapper\Entity,
    app\entities\Contract,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
    app\interfaces\ContractRowRepositoryInterface,
    app\interfaces\ContractRepositoryInterface,
    app\interfaces\SettingsRepositoryInterface
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
     * @param ContractRowRepositoryInterface $rowsRepository
     * @param ArticleRepositoryInterface $articleRepository
     * @param ClientRepositoryInterface $clientRepository
     */
    public function create(
        ContractRowRepositoryInterface $rowsRepository,
        ArticleRepositoryInterface $articleRepository,
        ClientRepositoryInterface $clientRepository
    )
    {
        $row = $rowRepository->create();
        $this->_create([
            'clients' => $clientRepository->getSelectList(),
            'articlesList' => $articleRepository->getSelectList(),
            'articles' => $articleRepository->findAllRaw(),
            'row' => $row,
            'rows' => array($row),
        ]);
    }

    /**
     * @param ContractRowRepositoryInterface $rowsRepository
     * @param ArticleRepositoryInterface $articleRepository
     * @param ClientRepositoryInterface $clientRepository
     * @param int $pk
     * @param array $params
     */
    public function update(
        ContractRowRepositoryInterface $rowRepository,
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