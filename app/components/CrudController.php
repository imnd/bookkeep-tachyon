<?php
namespace app\components;

use tachyon\components\Flash,
    tachyon\dic\Container;

/**
 * class Controller
 * Базовый класс для всех контроллеров
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class CrudController extends \tachyon\Controller
{
    use \tachyon\traits\Authentication;

    protected $layout = 'crud';
    protected $modelName;
    protected $model;
    protected $message;

    protected $postActions = array('delete', 'deactivate');
    /** @inheritdoc */
    protected $protectedActions = '*';

    /**
     * @var tachyon\components\Flash
     */
    protected $flash;

    public function __construct(Flash $flash, ...$params)
    {
        $this->flash = $flash;

        parent::__construct(...$params);
    }

    /** @inheritdoc */
    public function init()
    {
        if (is_null($this->modelName)) {
            $this->modelName = ucfirst($this->id);
        }
        $this->model = (new Container)->get("\\app\\models\\{$this->modelName}");
        $this->model->setAttributes($this->get);
    }

    /**
     * Хук, срабатывающий перед запуском экшна
     * @return boolean
     */
    public function beforeAction()
    {
        if (!parent::beforeAction()) {
            return false;
        }
        if ($this->protectedActions==='*' || in_array($this->action, $this->protectedActions)) {
            $this->checkAccess();
        }
        return true;
    }

    /**
     * Главная страница, список сущностей раздела
     */
    public function index()
    {
        $this->view->setPageTitle(ucfirst($this->model->getEntityName('plural')) . ', список');
        $this->layout('index', [
            'model' => $this->model,
            'items' => $this->model
                ->setSearchConditions($this->get)
                ->setSortConditions($this->get)
                ->findAllScalar(),
        ]);
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
        echo json_encode([
            'success' => $this->model
                ->findByPk($pk)
                ->delete()
        ]);
    }

    /**
     * Делает сущность неактивной
     * @return boolean
     */
    public function deactivate($pk)
    {
        // переписать
        echo json_encode([
            'success' => $this->model
                ->findByPk($pk)
                ->get('activeBehaviour')
                ->deactivate($this->model)
        ]);
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
                $this->flash->setFlash('Сохранено успешно', self::FLASH_TYPE_SUCCESS);
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
