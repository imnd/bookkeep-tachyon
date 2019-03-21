<?php
namespace app\controllers;

use app\models\ContractsRows,
    app\models\Settings;

/**
 * class Index
 * Контроллер
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ContractsController extends \app\components\CrudController
{
    protected $layout = 'contracts';

    /**
     * Главная страница, список договоров
     */
    public function index($type=null)
    {
        $this->layout('index', [
            'type' => $type,
            'model' => $this->model,
            'items' => $this->model
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(/*is_null($type) ? array() : compact('type')*/),
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
        $this->layout('printout', compact('contract', 'rows', 'quantitySum', 'typeName', 'term', 'firm'));
    }

    public function getItem($num)
    {
        echo json_encode($this->model->getItem(compact('num')));
    }
}