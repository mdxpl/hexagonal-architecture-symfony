<?php

namespace Application\Query;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Model\Article\Article;
use Domain\Model\Article\ArticleEvent;
use Domain\Model\Article\ArticleRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ListArticleQuery implements Query
{

    const LISTED = 'article.listed';

    private $articleRepository;
    private $eventDispatcher;

    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->articleRepository = $articleRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return ArrayCollection|Article[]
     */
    public function execute(): ArrayCollection
    {
        $list = $this->articleRepository->getList();
        foreach ($list as $article) {
            $this->eventDispatcher->dispatch(
                self::LISTED,
                new ArticleEvent($article)
            );
        }

        return $list;
    }

}