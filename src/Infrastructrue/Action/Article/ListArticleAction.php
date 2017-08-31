<?php

namespace Infrastructure\Action\Article;

use Application\Query\ListArticleQuery;
use Infrastructure\Action\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class ListArticleAction implements Action
{
    private $templating;
    private $query;

    public function __construct(EngineInterface $templating, ListArticleQuery $query)
    {
        $this->templating = $templating;
        $this->query = $query;
    }

    public function __invoke(Request $request): Response
    {
        return $this->templating->renderResponse('Article/ListArticleAction.html.twig', [
            'articles' => $this->query->execute(),
        ]);
    }

}
