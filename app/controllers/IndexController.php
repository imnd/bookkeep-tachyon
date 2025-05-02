<?php
namespace app\controllers;

use
    app\models\Users,
    tachyon\Controller,
    tachyon\Config,
    tachyon\components\Flash,
    tachyon\traits\Auth,
    tachyon\interfaces\AuthInterface;

/**
 * @author imndsu@gmail.com
 */
class IndexController extends Controller implements AuthInterface
{
    use Auth;

    public function __construct(
        protected Config $config,
        protected Users $users,
        protected Flash $flash,
        ...$params
    ) {
        parent::__construct(...$params);
    }

    /**
     * Главная страница
     */
    public function index(): void
    {
        $this->view();
    }

    /**
     * Страница логина
     */
    public function login(): void
    {
        if (!$this->request->isPost()) {
            $this->view('login');
            return;
        }
        if (!$user = $this->users->findByPassword([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ])) {
            $this->unauthorised('Пользователя с таким логином и паролем нет.');
        }
        if ((int)$user->confirmed !== Users::STATUS_CONFIRMED) {
            $this->unauthorised('Вы не подтвердили свою регистрацию.');
        }
        $this->_login($this->request->getPost('remember'));

        $this->redirect($this->request->getReferer());
    }

    /**
     * Страница логаута
     */
    public function logout(): void
    {
        $this->_logout();
        $this->redirect('/index');
    }

    /**
     * Страница регистрации
     */
    public function register(): void
    {
        $msg = $error = '';
        if ($this->request->isPost() && $user = $this->users->add(
            [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'password_confirm' => $this->request->getPost('password_confirm'),
            ]
        )) {
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
        $this->view('register', compact('msg', 'error'));
    }

    /**
     * Страница подтверждения регистрации
     */
    public function activate(): void
    {
        if (
                $user = $this->users->findOne(array(
                    'email' => $this->request->getGet()['email'],
                ))
            and $user->confirm_code===$this->request->getGet('confirm_code')
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
