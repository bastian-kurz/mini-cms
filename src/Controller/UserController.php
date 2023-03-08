<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\ListServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UserController extends AbstractController
{
    private ListServiceInterface $userListService;

    private Environment $twig;

    public function __construct(ListServiceInterface $userListService, Environment $twig)
    {
        $this->userListService = $userListService;
        $this->twig = $twig;
    }

    #[Route('/user', name: 'user', defaults: ['auth_required' => false], methods: ['GET'])]
    public function showUser(): Response
    {
        $user = $this->userListService->fetchList();
        $userData = $this->userListService->convert($user);
        $content = $this->twig->render(
            'Frontend/user_list.html.twig',
            [
                'users' => $userData
            ]
        );

        return new Response($content);
    }
}
