<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
trait Article
{
    /**
     * @return string
     */
    public function getArticleName()
    {
        if ($article = $this->article) {
            return $article->name;
        }
    }

    /**
     * @return string
     */
    public function getArticleUnit()
    {
        if ($article = $this->article) {
            return $article->unit;
        }
    }
}
