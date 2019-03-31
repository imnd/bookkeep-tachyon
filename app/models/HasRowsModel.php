<?php
namespace app\models;

use tachyon\dic\Container,
    tachyon\helpers\ArrayHelper;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 * 
 * Класс модели табличного документа
 */
class HasRowsModel extends \tachyon\db\activeRecord\ActiveRecord
{
    protected $rowModelName;
    protected $rowModel;
    protected $rowFk;

    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->rowModel = (new Container)->get("\\app\\models\\{$this->rowModelName}");
        $this->relations['rows'] = array($this->rowModelName, 'has_many', $this->rowFk);
    }

    public function getItem($where=array())
    {
        $item = $this
            ->addWhere($where)
            ->findOneRaw();
            
        $item['rows'] = $this->rowModel
            ->addWhere([
                $this->rowFk => $item['id'],
            ])
            ->findAllRaw();

        return $item;
    }

    public function getTotal($where = array())
    {
        if ($result = $this
            ->addWhere($where)
            ->select('SUM(sum) AS total')
            ->findAllRaw())
            return $result[0]['total'];
        
        return 0;
    }

    public function getQuantitySum($pk): int
    {
        $this
            ->limit(1)
            ->joinRelation(array('rows' => 'r'))
            ->select('SUM(r.quantity) AS quantitySum');

        if ($result = parent::findAllRaw(array($this->pkName => $pk))) {
            return $result[0]['quantitySum'];
        }
        return 0;
    }

    protected function afterSave(): bool
    {
        // удаляем строки
        $this->deleteRelatedModels('rows');

        $sum = 0;
        if (isset($_POST[$this->rowModelName])) {
            $rowsData = ArrayHelper::transposeArray($_POST[$this->rowModelName]);
            $thisPk = $this->getPk();
            $rowFk = $this->rowFk;
            $container = new Container;
            foreach ($rowsData as $rowData) {
                $row = $container->get($this->rowModelName);
                $row->setAttributes($rowData);
                $row->$rowFk = $thisPk;
                $row->save();
                $sum += $row->sum;
            }
        }
        $this->saveAttrs(compact('sum'));
    }

    # геттеры
    
    public function getRowModelName()
    {
        return $this->rowModelName;
    }
}
