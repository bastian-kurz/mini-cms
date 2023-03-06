<?php

declare(strict_types=1);

namespace App\Api\Controller;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use OpenApi\Attributes as OA;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private AuthorizationServer $authorizationServer;

    private HttpMessageFactoryInterface $psrHttpFactory;

    public function __construct(AuthorizationServer $authorizationServer, HttpMessageFactoryInterface $psrHttpFactory)
    {
        $this->authorizationServer = $authorizationServer;
        $this->psrHttpFactory = $psrHttpFactory;
    }

    /**
     * @throws OAuthServerException
     */
    #[OA\Post(
        path: '/oauth/token',
        operationId: 'token',
        description: 'Fetch a access token that can be used to perform authenticated requests',
        summary: 'Fetch an access token',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                description: 'For more information take a look at the [Authentication documentation]',
                required: ['grant_type'],
                properties: [
                    new OA\Property(
                        property: 'grant_type',
                        description: 'The grant type that should be used. See [OAuth 2.0 grant](https://oauth2.thephpleague.com/authorization-server/which-grant/) for more information.',
                        type: 'string',
                        enum: ['password', 'refresh_token', 'client_credentials']
                    )
                ]
            )
        ),
        tags: ['API', 'Authorization & Authentication'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Authorized successfully.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'token_type',
                            description: 'Type of the token.',
                            type: 'string'
                        ),
                        new OA\Property(
                            property: 'expires_in',
                            description: 'Token lifetime in seconds.',
                            type: 'integer'
                        ),
                        new OA\Property(
                            property: 'access_token',
                            description: 'The access token that can be used for subsequent requests',
                            type: 'string'
                        )
                    ]
                )
            )
        ]
    )
    ]
    #[Route('/api/oauth/token', name: 'api.oauth.token', defaults: ['auth_required' => false], methods: ['POST'])]
    public function token(Request $request): Response
    {
        $response = new Response();
        $psr7Request = $this->psrHttpFactory->createRequest($request);
        $psrResponse = $this->psrHttpFactory->createResponse($response);

        $response = $this->authorizationServer->respondToAccessTokenRequest($psr7Request, $psrResponse);

        return (new HttpFoundationFactory())->createResponse($response);
    }
}
