<?php

namespace Infrastructure\Action\Article;

use Infrastructure\Action\Action;
use Infrastructure\Form\Type\CreateArticleFormType;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

class CreateArticleAction implements Action
{
    private $templating;
    private $router;
    private $formFactory;
    private $commandBus;
    private $session;

    public function __construct(
        EngineInterface $templating,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        SessionInterface $session,
        MessageBus $commandBus
    )
    {
        $this->templating = $templating;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(CreateArticleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->commandBus->handle($form->getData());
                return $this->onSuccess();
            }
        }

        return $this->templating->renderResponse('Article/CreateArticleAction.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function onSuccess(): Response
    {
        $this->session->getFlashBag()->add('success', 'Article has been created.');

        return new RedirectResponse($this->router->generate('article_list'));
    }

}
