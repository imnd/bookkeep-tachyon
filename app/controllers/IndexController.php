<?php
namespace app\controllers;

use tachyon\Config,
    app\models\Users,
    tachyon\components\Flash;

/**
 * Контроллер начальной страницы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class IndexController extends \tachyon\Controller
{
    use \tachyon\traits\Authentication;

    /**
     * @var Config $config
     */
    protected $config;
    /**
     * @var Users
     */
    protected $users;
    /**
     * @var Flash
     */
    protected $flash;

    /**
     * @param Config $config
     * @param Users $users
     * @param Flash $flash
     */
    public function __construct(Config $config, Users $users, Flash $flash, ...$params)
    {
        $this->config = $config;
        $this->users = $users;
        $this->flash = $flash;

        parent::__construct(...$params);
    }

    /**
     * Главная страница
     */
    public function index()
    {
        $this->view();
    }

    /**
     * Страница логина
     */
    public function login()
    {
        if ($this->isRequestPost()) {
            if ($user = $this->users->findByPassword(array(
                'username' => $this->post['username'],
                'password' => $this->post['password'],
            ))) {
                if ($user->confirmed == Users::STATUS_CONFIRMED) {
                    $this->_login($this->post['remember']);
                    $this->redirect($this->getReferer());
                }
                $error = 'Вы не подтвердили свою регистрацию.';
            } else {
                $error = 'Пользователя с таким логином и паролем нет.';
            }
        }
        $this->view('login', compact('error'));
    }

    /**
     * Страница логаута
     */
    public function logout()
    {
        $this->_logout();
        $this->redirect('/index');
    }

    /**
     * Страница регистрации
     */
    public function register()
    {
        if ($this->isRequestPost()) {
            if ($user = $this->users->add(array(
                'username' => $this->post['username'],
                'email' => $this->post['email'],
                'password' => $this->post['password'],
                'password_confirm' => $this->post['password_confirm'],
            ))) {
                if (!$user->hasErrors()) {
                    $msg = 'Пожалуйста подтвердите свою регистрацию';
                    $email = $user->email;
                    $activationUrl = "{$_SERVER['HTTP_ORIGIN']}/index/activate?confirm_code={$user->confirm_code}&email=$email";
                    mail($email, 'Подтверждение регистрации', "$msg перейдя по ссылке: $activationUrl");

                    $msg .= ". На ваш почтовый ящик $email придет письмо со ссылкой подтверждения.";
                    $this->view('register-end', compact('msg'));
                    return;
                }
                $error = $user->getErrorsSummary();
            }
        }
        $this->view('register', compact('msg', 'error'));
    }

    /**
     * Страница подтверждения регистрации
     */
    public function activate()
    {
        if (
                $user = $this->users->findOne(array(
                    'email' => $this->get['email'],
                ))
            and $user->confirm_code===$this->get['confirm_code']
        ) {
            $user->setAttribute('confirmed', Users::STATUS_CONFIRMED);
            $user->update();
            $msg = 'Регистрация прошла успешно.';
        } else {
            $error = 'Неправильная ссылка.';
        }
        $this->view('register-end', compact('msg', 'error'));
    }
}
