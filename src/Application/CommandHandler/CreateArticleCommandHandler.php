<?php

namespace Application\CommandHandler;

use Application\Command\CreateArticleCommand;
use Domain\Model\Article\ArticleEvent;
use Domain\Model\Article\ArticleRepositoryInterface;
use Domain\Model\Article\Article;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateArticleCommandHandler
{

    const CREATED = 'article.created';

    private $articleRepository;
    private $eventDispatcher;

    public function __construct(ArticleRepositoryInterface $articleRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->articleRepository = $articleRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(CreateArticleCommand $command): void
    {

        $article = new Article(
            uniqid(),
            false,
            $command->getTitle(),
            $command->getContent()
        );

        $this->articleRepository->create($article);
        $this->eventDispatcher->dispatch(self::CREATED, new ArticleEvent($article));

    }

}