<?php
namespace app\components;

/**
 * class Controller
 * Базовый класс для всех контроллеров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class CrudController extends \tachyon\Controller
{
    use \app\traits\MenuTrait;

    protected $modelName;
    protected $model;
    protected $message;

    protected $postActions = array('delete', 'deactivate');
    /** @inheritdoc */
    protected $protectedActions = '*';

    /** @inheritdoc */
    public function init()
    {
        $this->mainMenu = [
            'index' => 'список',
            'create' => 'добавить',
        ];
        if (is_null($this->modelName)) {
            $this->modelName = ucfirst($this->id);
        }
        $this->model = $this->get($this->modelName);
        $this->model->setAttributes($this->get);
    }

    /**
     * Главная страница, список сущностей раздела
     */
    public function index()
    {
        $this->view->setPageTitle(ucfirst($this->model->getEntityName('plural')) . ', список');
        $this->layout('index', array(
            'model' => $this->model,
            'items' => $this->model
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(),
        ));
    }

    public function view($pk)
    {
        if (!$model = $this->model->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        $this->view->setPageTitle(ucfirst($this->model->getEntityName('single')) . " №{$model->number}, просмотр");

        $this->layout('view', compact('model', 'pk'));
    }

    public function create()
    {
        $this->view->setPageTitle(ucfirst($this->model->getEntityName('single')) . ', добавление');
        $this->saveModel();

        $this->layout('create', array('model' => $this->model));
    }

    public function update($pk)
    {
        if (!$model = $this->model->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        $this->view->setPageTitle(ucfirst($this->model->getEntityName('single')) . ', редактирование');
        $this->saveModel($model);

        $this->layout('update', compact('model', 'pk'));
    }

    public function delete($pk)
    {
        echo json_encode(array(
            'success' => $this->model
                ->findByPk($pk)
                ->delete()
        ));
    }

    /**
     * Делает сущность неактивной
     * @return boolean
     */
    public function deactivate($pk)
    {
        echo json_encode(array(
            'success' => $this->model
                ->findByPk($pk)
                ->get('activeBehaviour')
                ->deactivate($this->model)
        ));
    }

    /**
     * @param $model \tachyon\db\activeRecord\ActiveRecord
     * @return void
     */
    protected function saveModel($model=null)
    {
        if (is_null($model)) {
            $model = $this->model;
        }
        if (!empty($this->post)) {
            $model->setAttributes($this->post[$model->getClassName()] ?? $this->post);

            if ($model->save()) {
                // TODO: сделать flash-сообщения
                $this->message = 'Сохранено успешно';
                $this->redirect("/{$this->id}");
            }
            $this->message = 'Что то пошло не так';
        }
    }

    # геттеры

    /**
     * @return string
     */
    public function getMessage()//: ?string
    {
        return $this->message;
    }
}
