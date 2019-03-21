<?php
namespace app\components;

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
    protected $rowFk;

    public function __construct(...$params)
    {
        $this->relations['rows'] = array($this->rowModelName, 'has_many', $this->rowFk);

        parent::__construct(...$params);
    }

    public function getItem($where=array())
    {
        $item = $this
            ->addWhere($where)
            ->findOneScalar();
            
        $item['rows'] = (new Container)->get("\\app\\models\\{$this->rowModelName}")
            ->addWhere([
                $this->rowFk => $item['id'],
            ])
            ->findAllScalar();

        return $item;
    }

    public function getTotal($where = array())
    {
        if ($result = $this
            ->addWhere($where)
            ->select('SUM(sum) AS total')
            ->findAllScalar())
            return $result[0]['total'];
        
        return 0;
    }

    public function getQuantitySum($pk): int
    {
        $this
            ->limit(1)
            ->joinRelation(array('rows' => 'r'))
            ->select('SUM(r.quantity) AS quantitySum');

        if ($result = parent::findAllScalar(array($this->pkName => $pk))) {
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
