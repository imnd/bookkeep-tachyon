<?php
namespace app\components;

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

    public function __construct()
    {
        $this->relations['rows'] = array($this->rowModelName, 'has_many', $this->rowFk);

        parent::__construct();
    }

    public function getItem($where=array())
    {
        $item = $this
            ->addWhere($where)
            ->findOneScalar();
            
        $item['rows'] = $this->get($this->rowModelName)
            ->addWhere(array(
                $this->rowFk => $item['id'],
            ))
            ->findAllScalar();

        return $item;
    }

    public function getTotal($where=array())
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

        if ($result = parent::findAllScalar(array(static::$primKey => $pk)))
            return $result[0]['quantitySum'];

        return 0;
    }

    protected function afterSave(): bool
    {
        // удаляем строки
        $this->deleteRelatedModels('rows');

        $sum = 0;
        if (isset($_POST[$this->rowModelName])) {
            $rowsData = \tachyon\helpers\ArrayHelper::transposeArray($_POST[$this->rowModelName]);
            $thisPk = $this->getPrimKeyVal();
            $rowFk = $this->rowFk;
            foreach ($rowsData as $rowData) {
                $row = $this->get($this->rowModelName);
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
