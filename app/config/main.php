<?php return array(
    // язык
    'lang' => 'ru',
    // кодировка
    'encoding' => 'utf-8',
    'base_path' => '/',
    // режим исполнения приложения
    'mode' => 'production',
    'csrf_check' => false,
    // переменные сайта
    'site_vars' =>  array(
        'copyright' => 'а.сердюк',
        'author_email' => 'imndsu@gmail.com',
    ),
    'db' => require 'db.php',
);