<?php return [
    // язык
    'lang' => 'ru',
    // продолжительность логина при нажатой кнопке "remember me"
    'remember' => 7, // неделя
    'csrf_check' => false,
    'cache' => [
        'enabled' => true,
        'serialize' => true,
    ],
    'db' => require 'db.php',
    'routes' => require 'routes.php',
];