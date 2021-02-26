<?php
namespace tests;

use PHPUnit\Framework\TestCase,
    GuzzleHttp\Client as HttpClient,
    tachyon\db\dbal\DbFactory,
    tachyon\db\dataMapper\Persistence,
    tachyon\db\dataMapper\Repository,
    tachyon\Config,
    app\repositories\ArticlesRepository,
    app\repositories\ArticleSubcatsRepository,
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
 * @copyright (c) 2020 IMND
 */
final class ArticlesTest extends TestCase
{
    /**
     * @var HttpClient
     */
    protected $client;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->config = new Config('main-test');
        $persistence  = new Persistence(new DbFactory($this->config));
        $articleSubcatRepository = new ArticleSubcatsRepository(new ArticleSubcat, $persistence);
        $this->repository = new ArticlesRepository(new Article, $articleSubcatRepository, $persistence);

        $this->client = new HttpClient([
            'base_uri' => $this->config->get('base-url'),
            'timeout'  => 2.0,
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
