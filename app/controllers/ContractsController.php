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
    /**
     * @var app\models\ContractsRows
     */
    protected $contractsRows;
    /**
     * @var app\models\Settings
     */
    protected $settings;

    public function __construct(ContractsRows $contractsRows, Settings $settings, ...$params)
    {
        $this->contractsRows = $contractsRows;
        $this->settings = $settings;

        parent::__construct(...$params);
    }
    
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        // переместить в шаблон
        $this->mainMenu = [
            'index/contract' => 'список контрактов',
            'index/agreement' => 'список договоров',
            'create' => 'добавить',
        ];
    }

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
                ->findAllScalar(is_null($type) ? array() : compact('type')),
        ]);
    }

    public function printout($pk)
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
        $rows = $this->contractsRows->getAllByContract($pk);
        $firm = $this->settings->getRequisites('firm');
        $this->layout('printout', compact('contract', 'rows', 'quantitySum', 'typeName', 'term', 'firm'));
    }

    public function getItem($num)
    {
        echo json_encode($this->model->getItem(compact('num')));
    }
}