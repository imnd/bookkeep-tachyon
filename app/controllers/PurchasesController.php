<?php
namespace app\controllers;

use tachyon\db\dataMapper\Entity,
    app\entities\Purchase,
    app\interfaces\ArticleRepositoryInterface,
    app\interfaces\ClientRepositoryInterface,
    app\interfaces\PurchaseRowRepositoryInterface,
    app\interfaces\PurchaseRepositoryInterface,
    app\interfaces\SettingsRepositoryInterface
;

/**
 * class Purchases
 * Контроллер закупок
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class PurchasesController extends HasRowsController
{
    /**
     * @param PurchaseRepositoryInterface $repository
     * @param PurchaseRowRepositoryInterface $rowRepository
     * @param array $params
     */
    public function __construct(
        PurchaseRepositoryInterface $repository,
        PurchaseRowRepositoryInterface $rowRepository,
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
     */
    public function index(
        Purchase $entity,
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
     * Собираем закупку за определенное число
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

     
    public function create__()
    {
        $rowModel = $this->rowModel;
        if (!empty($this->get['date'])) {
            $date = $this->get['date'];
            $items = $this->model->getReport($date);
        } else {
            // Текущая дата в стандартном формате
            $date = date('Y-m-d');
            $items = array();
        }
        $this->model->date = $date;
        if (!empty($this->post)) {
            $this->model->setAttributes($this->post[$this->modelName]);
            if ($this->model->save())
                $this->redirect("/{$this->id}");
        }
        $this->layout('create', compact('model', 'rowModel', 'date', 'items'));
    }

    /**
     * @param PurchaseRowRepositoryInterface $rowsRepository
     * @param ArticleRepositoryInterface $articleRepository
     * @param ClientRepositoryInterface $clientRepository
     * @param int $pk
     * @param array $params
     */
    public function update(
        PurchaseRowRepositoryInterface $rowRepository,
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
