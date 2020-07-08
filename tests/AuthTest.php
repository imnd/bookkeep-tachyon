<?php
namespace tests;

use tachyon\components\TestCase;

/**
 * Тестовый класс для модели Articles
 * 
 * cd D:\wamp\www\bookkeep
 * .\vendor\bin\phpunit tests/ArticlesTest
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
final class AuthTest extends TestCase
{
    /**
     * Авторизация
     * @test
     * @return void
     */
    public function auth()
    {
        // форма логина
        $res = $this->httpClient->request('GET', 'login');
        $this->assertTrue($res->getStatusCode()===200);
        // неудачный логин
        /*$res = $this->httpClient->request('POST', 'login', [
            'form_params' => [
                'username' => 'admin',
                'password' => 'qaswedfrqaswedfr',
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);
        $this->assertTrue($res->getStatusCode()===401);*/
        // удачный логин
        $res = $this->httpClient->request('POST', 'login', [
            'form_params' => [
                'username' => 'admin',
                'password' => 'qaswedfr',
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);
        $this->assertTrue($res->getStatusCode()===200);
    }
}
