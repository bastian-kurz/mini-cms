<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class LoginController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/login', name: 'login', defaults: ['auth_required' => false], methods: ['GET'])]
    public function login(): Response
    {
        return new Response($this->twig->render('Frontend/login.html.twig'));
    }
}
