<?php
namespace app\controllers;

/**
 * Контроллер начальной страницы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class IndexController extends \tachyon\Controller
{
    use \app\traits\MenuTrait;

    /**
     * Главная страница
     */
    public function index()
	{
		$this->layout();
	}

    /**
     * Страница логина
     */
    public function login()
    {
        if ($this->isRequestPost()) {
            if ($user = $this->get('Users')->find(array(
                'username' => $this->post['username'],
                'password' => $this->post['password'],
            ))) {
                if ($user->confirmed == Users::STATUS_CONFIRMED) {
                    $this->_login($this->post['remember']);
                    $this->redirect('/');
                }
                $error = 'Вы не подтвердили свою регистрацию.';
            } else {
                $error = 'Пользователя с таким логином и паролем нет.';
            }
        }
        $this->layout('login', compact('error'));
    }

    /**
     * Страница логаута
     */
    public function logout()
    {
        $this->_logout();
        $this->redirect('/blogs');
    }

    /**
     * Страница регистрации
     */
    public function register()
    {
        if ($this->isRequestPost()) {
            if ($user = $this->get('Users')->add(array(
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
                    $this->layout('register-end', compact('msg'));
                    return;
                }
                $error = $user->getErrorsSummary();
            }
        }
        $this->layout('register', compact('msg', 'error'));
    }

    /**
     * Страница подтверждения регистрации
     */
    public function activate()
    {
        if ($user = $this->get('Users')->findOne(array(
            'email' => $this->get['email'],
        )));
        if ($user->confirm_code===$this->get['confirm_code']) {
            $user->setAttribute('confirmed', Users::STATUS_CONFIRMED);
            $user->update();
            $msg = "Регистрация прошла успешно.";
        } else {
            $error = "Неправильная ссылка.";
        }
        $this->layout('register-end', compact('msg', 'error'));
    }
}
