<?php

declare(strict_types=1);

namespace App\Api\User\Controller;

use App\Core\ListServiceInterface;
use OpenApi\Attributes as OA;
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

    #[OA\Get(
        path: '/api/user',
        operationId: '',
        description: 'Fetch a list of all users',
        summary: '',
        tags: ['API'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Get users list successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'userName', type: 'string'),
                        new OA\Property(property: 'email', type: 'string'),
                        new OA\Property(property: 'address', properties: [
                            new OA\Property(property: 'street', type: 'string'),
                            new OA\Property(property: 'suite', type: 'string'),
                            new OA\Property(property: 'city', type: 'string'),
                            new OA\Property(property: 'zipcode', type: 'string'),
                            new OA\Property(property: 'geo', properties: [
                                new OA\Property(property: 'lat', type: 'string'),
                                new OA\Property(property: 'lng', type: 'string')
                            ], type: 'object'),
                        ], type: 'object'),
                        new OA\Property(property: 'phone', type: 'string'),
                        new OA\Property(property: 'website', type: 'string'),
                        new OA\Property(property: 'company', properties: [
                            new OA\Property(property: 'name', type: 'string'),
                            new OA\Property(property: 'catchPhrase', type: 'string'),
                            new OA\Property(property: 'bs', type: 'string')
                        ], type: 'object')
                    ]
                )
            )
        ]
    )]
    #[Route('/api/user', name: 'api.user.list', defaults: ['auth_required' => false], methods: ['GET'])]
    public function list(): Response
    {
        return (new Response())->setContent($this->userListService->fetchList());
    }
}