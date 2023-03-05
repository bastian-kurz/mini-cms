<?php

declare(strict_types=1);

namespace App\Api\Controller;

use League\Event\EmitterAwareInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private EmitterAwareInterface $authorizationServer;

    private HttpMessageFactoryInterface $psrHttpFactory;

    public function __construct(EmitterAwareInterface $authorizationServer, HttpMessageFactoryInterface $psrHttpFactory)
    {
        $this->authorizationServer = $authorizationServer;
        $this->psrHttpFactory = $psrHttpFactory;
    }

    #[Route('/api/oauth/token', name: 'api.oauth.token', defaults: ['auth_required' => false], methods: ['GET'])]
    public function token(Request $request): Response
    {
        return (new Response('{"success": true}'));
    }
}
