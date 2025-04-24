<?php
use
    tachyon\components\TestCase,
    tachyon\db\dbal\DbFactory,
    tachyon\db\dataMapper\Persistence,
    tachyon\db\dataMapper\Repository,
    app\repositories\ArticlesRepository,
    app\repositories\ArticleSubcatsRepository,
    app\entities\Article,
    app\entities\ArticleSubcat
;

/**
 * Тестовый класс для модели Articles
 *
 * cd [project root]
 * .\vendor\bin\phpunit tests/ArticlesTest
 *
 * @author imndsu@gmail.com
 */
final class ArticlesTest extends TestCase
{
    protected Repository $repository;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $persistence  = new Persistence(new DbFactory($this->config));
        $articleSubcatRepository = new ArticleSubcatsRepository(new ArticleSubcat, $persistence);
        $this->repository = new ArticlesRepository(new Article, $articleSubcatRepository, $persistence);
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
    public function authenticated_users_can_create_article(): void
    {

    }

    /**
     * Неавторизированные пользователи не могут создавать товары
     * @test
     */
    public function unauthenticated_users_cant_create_article(): void
    {

    }
}
