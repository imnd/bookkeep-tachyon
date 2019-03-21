<?php return array(
    // контроллер по умолчанию
    'defaultController' => 'Index',
    // язык
    'lang' => 'ru',
    // продолжительность логина при нажатой кнопке "remember me"
    'remember' => 7, // неделя
    // кодировка
    'encoding' => 'utf-8',
    'base_path' => '/',
    // режим исполнения приложения
    'mode' => 'production',
    'csrf_check' => false,
    // переменные сайта
    'site_vars' =>  [
        'copyright' => 'а.сердюк',
        'author_email' => 'imndsu@gmail.com',
    ],
    'db' => require 'db.php',
    'cache' => [
        'enabled' => true,
        'serialize' => true,
    ],
);