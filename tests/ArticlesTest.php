<?php
namespace tests;

use
    tachyon\components\TestCase,
    tachyon\db\dbal\DbFactory,
    tachyon\db\dataMapper\Persistence,
    app\repositories\ArticleRepository,
    app\repositories\ArticleSubcatRepository,
    app\entities\Article,
    app\entities\ArticleSubcat
;

/**
 * Тестовый класс для модели Articles
 * 
 * cd D:\wamp\www\bookkeep
 * .\vendor\bin\phpunit tests/ArticlesTest
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
final class ArticlesTest extends TestCase
{
    /**
     * Авторизированные пользователи могут создавать товары
     * @test
     * @return void
     */
    public function authenticated_users_can_create_article()
    {
        
    }

    /**
     * Неавторизированные пользователи не могут создавать товары
     * @test
     */
    public function unauthenticated_users_cant_create_article()
    {
        
    }
}
