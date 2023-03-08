<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BackendController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/backend', name: 'backend', defaults: ['auth_required' => true], methods: ['GET'])]
    public function backendRender(): Response
    {
        return new Response($this->twig->render('Backend/backend.html.twig'));
    }
}
