<?php
use GuzzleHttp\Exception\GuzzleException;
use tachyon\components\TestCase;

/**
 * Тестовый класс для модели Articles
 *
 * cd D:\wamp\www\bookkeep
 * .\vendor\bin\phpunit tests/ArticlesTest
 *
 * @author imndsu@gmail.com
 */
final class AuthTest extends TestCase
{
    /**
     * Авторизация
     *
     * @test
     * @return void
     * @throws GuzzleException
     */
    public function auth(): void
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
