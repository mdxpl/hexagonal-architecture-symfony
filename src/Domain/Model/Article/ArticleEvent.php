<?php

namespace Domain\Model\Article;

use Symfony\Component\EventDispatcher\Event;

class ArticleEvent extends Event
{

    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

}