<?php return [
    // язык
    'lang' => 'ru',
    // продолжительность логина при нажатой кнопке "remember me"
    'remember' => 7, // неделя
    // кодировка
    'encoding' => 'utf-8',
    'base_url' => 'http://bookkeep/',
    // режим исполнения приложения
    'mode' => 'debug',
    'csrf_check' => false,
    'cache' => [
        'enabled' => true,
        'serialize' => true,
    ],
    'db' => require 'db.php',
    'routes' => require 'routes.php',
];