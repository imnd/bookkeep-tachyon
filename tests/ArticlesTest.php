<?php
namespace tests;

use PHPUnit\Framework\TestCase,
    GuzzleHttp\Client,
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
     * @var GuzzleHttp\Client $client 
     */
    protected $client;
    /**
     * @var Config $config
     */
    protected $config;
    protected $repository;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->config = new Config('main-test');
        $dbFactory = new DbFactory($this->config);
        $persistence = new Persistence($dbFactory);
        $articleSubcatRepository = new ArticleSubcatRepository(new ArticleSubcat, $persistence);
        $this->repository = new ArticleRepository(new Article, $articleSubcatRepository, $persistence);
        
        $this->client = new Client([
            'base_uri' => $this->config->get('base-url'),
            'timeout' => 2.0,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        $this->repository->clear();
    }

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
