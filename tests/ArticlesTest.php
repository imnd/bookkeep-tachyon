<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use app\models\Articles;

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
    public function testObjectHasAttribute()
    {
        $this->assertObjectHasAttribute(
            'subcat_id',
            Articles::getInstance()
        );
    }
}
