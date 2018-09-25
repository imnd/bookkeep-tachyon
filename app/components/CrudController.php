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
    /**
     * @inheritdoc
     */
    protected $mainMenu = array(
        'index' => 'список',
        'create' => 'добавить',
    );

    protected $modelName;
    protected $model;
    protected $message;

    protected $postActions = array('delete', 'deactivate');

    /** @inheritdoc */
    protected $protectedActions = '*';

    /** @inheritdoc */
    public function init()
    {
        $this->view->setProperty('bodyClass', "{$this->id} {$this->action}");

        $modelName = ucfirst($this->id);
        if (is_null($this->modelName))
            $this->modelName = $modelName;

        $this->model = $this->get($modelName);
        $this->model->setAttributes($this->get);
    }

    /** @inheritdoc */
    public function beforeAction(): bool
    {
        if (!parent::beforeAction())
            return false;

        if ($this->action=='printout')
            $this->layout = 'printout';

        return true;
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
                ->getAll(),
        ));
    }

    public function view($pk)
    {
        if (!$model = $this->model->findByPk($pk))
            $this->error(404, $this->msg->i18n('Wrong address.'));

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
        if (!$model = $this->model->findByPk($pk))
            $this->error(404, $this->msg->i18n('Wrong address.'));

        if (is_null($this->subMenu)) {
            $this->subMenu = array(
                array(
                    'action' => "delete/$pk",
                    'type' => 'ajax',
                    'confirmMsg' => 'удалить?',
                    'callback' => "window.location='/{$this->id}/'",
                ),
                "printout/$pk",
            );
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
     * Вывод сообщения об ошибке
     * todo: вынести в компонент
     * @param string $msg
     * @return void
     */
    public function error($code, $msg)
    {
        $codes = array(404 => 'Not Found');
        header("HTTP/1.0 $code {$codes[$code]}");
        $this->layout('/../error', compact('code', 'msg'));
        die;
    }

    /**
     * @param $model \tachyon\db\models\ArModel
     * @return void
     */
    protected function saveModel($model=null)
    {
        if (is_null($model))
            $model = $this->model;

        if (!empty($this->post)) {
            if (!empty($this->post[$model->getClassName()]))
                $model->setAttributes($this->post[$model->getClassName()]);
            else
                $model->setAttributes($this->post);

            if ($model->save()) {
                // TODO: сделать flash-сообщения
                $this->message = 'Сохранено успешно';
                $this->redirect("/{$this->id}");
            }
            $this->message = 'Что то пошло не так';
        }
    }

    # Геттеры

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
