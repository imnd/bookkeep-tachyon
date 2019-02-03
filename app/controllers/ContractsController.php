<?php
namespace app\controllers;

/**
 * class Index
 * Контроллер
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ContractsController extends \app\components\CrudController
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->mainMenu = array(
            'index/contract' => 'список контрактов',
            'index/agreement' => 'список договоров',
            'create' => 'добавить',
        );
    }

    /**
     * Главная страница, список договоров
     */
    public function index($type=null)
    {
        $this->layout('index', array(
            'type' => $type,
            'model' => $this->model,
            'items' => $this->model
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(compact('type')),
        ));
    }

    public function printout($pk)
    {
        $this->layout = 'printout';

        $contract = $this->model
            ->with('client')
            ->findByPk($pk);

        $quantitySum = $this->model->getQuantitySum($pk);
        $typeName = $this->model->getTypeName($contract->type);
        
        $termStart = $contract->dateTime->convDateToReadable($contract->term_start);
        $termEnd = $contract->dateTime->convDateToReadable($contract->term_end);
        $term = "с $termStart по $termEnd";
        $rows = $this->get('ContractsRows')->getAllByContract($pk);
        $firm = $this->get('Settings')->getRequisites('firm');
        $this->layout('printout', compact('contract', 'rows', 'quantitySum', 'typeName', 'term', 'firm'));
    }

    public function getItem($num)
    {
        echo json_encode($this->model->getItem(compact('num')));
    }
}