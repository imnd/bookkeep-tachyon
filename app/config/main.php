<?php return [
    // язык
    'lang' => 'ru',
    // продолжительность логина при нажатой кнопке "remember me"
    'remember' => 7, // неделя
    // кодировка
    'encoding' => 'utf-8',
    'base_path' => '/',
    // режим исполнения приложения
    'mode' => 'debug',
    'csrf_check' => false,
    // переменные сайта
    'site_vars' =>  [
        'copyright' => 'а.сердюк',
        'author_email' => 'imndsu@gmail.com',
    ],
    'cache' => [
        'enabled' => true,
        'serialize' => true,
    ],
    'db' => require 'db.php',
    'routes' => require 'routes.php',
];