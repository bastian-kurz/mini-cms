<?php

namespace App\Api\Content\Controller;

use App\Api\Response\JsonResponseType;
use App\Core\ApiControllerInterface;
use App\Core\CustomEntityRepositoryInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContentController extends AbstractController implements ApiControllerInterface
{
    private CustomEntityRepositoryInterface $customEntityRepository;

    private JsonResponseType $jsonResponseType;

    private string $class;

    public function __construct(CustomEntityRepositoryInterface $customEntityRepository, JsonResponseType $jsonResponseType, string $class)
    {
        $this->customEntityRepository = $customEntityRepository;
        $this->jsonResponseType = $jsonResponseType;
        $this->class = $class;
    }

    #[OA\Get(
        path: '/api/content/{id}',
        operationId: '',
        description: 'Fetch content for one entity',
        summary: '',
        tags: ['Content'],
        parameters: [new OA\PathParameter(name: 'id', required: true)],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Get content successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'isoCode', type: 'string'),
                            new OA\Property(property: 'title', type: 'string'),
                            new OA\Property(property: 'text', type: 'string'),
                            new OA\Property(property: 'createdAt', type: 'string'),
                            new OA\Property(property: 'updatedAt', type: 'string'),
                        ])
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request. Content ID must be an integer and larger than 0'
            ),
            new OA\Response(
                response: 401,
                description: 'Authorization information is missing or invalid.'
            ),
            new OA\Response(
                response: 403,
                description: 'Not found. Resource could not be found by given id.'
            ),
            new OA\Response(
                response: 500,
                description: 'Unexpected error.'
            )
        ]
    )]
    #[Route('/api/content/{id}', 'content.get', defaults: ['auth_required' => false], methods: ['GET'])]
    public function get(int $id): Response
    {
        $entity = $this->customEntityRepository->read(null, $id);
        return $this->jsonResponseType->createDetailResponse($entity, $id, $this->class);
    }

    #[OA\Get(
        path: '/api/content',
        operationId: '',
        description: 'Fetch content list',
        summary: '',
        tags: ['Content'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Get content list successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', properties: [
                            new OA\Property(property: '', properties: [
                                new OA\Property(property: 'id', type: 'integer'),
                                new OA\Property(property: 'isoCode', type: 'string'),
                                new OA\Property(property: 'title', type: 'string'),
                                new OA\Property(property: 'text', type: 'string'),
                                new OA\Property(property: 'createdAt', type: 'string'),
                                new OA\Property(property: 'updatedAt', type: 'string'),
                            ])
                        ])
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Authorization information is missing or invalid.'
            ),
            new OA\Response(
                response: 403,
                description: 'Not found. Resource could not be found by given id.'
            ),
            new OA\Response(
                response: 500,
                description: 'Unexpected error.'
            )
        ]
    )]
    #[Route('/api/content', 'content.list', defaults: ['auth_required' => false], methods: ['GET'])]
    public function list(Request $request): Response
    {
        $entities = $this->customEntityRepository->read($request->query->all(), null);
        return $this->jsonResponseType->createListResponse($entities);
    }

    #[OA\Post(
        path: '/api/content',
        operationId: '',
        description: 'Create content',
        summary: '',
        requestBody: new OA\RequestBody(request: 'das', required: true, content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'isoCode', required: ['true'], type: 'string', maxLength: 2, example: 'de'),
                new OA\Property(property: 'title', required: ['true'], type: 'string', maxLength: 100, example: 'Impressum'),
                new OA\Property(property: 'text', required: ['true'], type: 'string', example: 'Example text to show'),
            ]
        )),
        tags: ['Content'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Create content successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', properties: [
                            new OA\Property(property: null, properties: [
                                new OA\Property(property: 'id', type: 'integer'),
                                new OA\Property(property: 'isoCode', type: 'string'),
                                new OA\Property(property: 'title', type: 'string'),
                                new OA\Property(property: 'text', type: 'string'),
                                new OA\Property(property: 'createdAt', type: 'string'),
                                new OA\Property(property: 'updatedAt', type: 'string'),
                            ])
                        ])
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Authorization information is missing or invalid.'
            ),
            new OA\Response(
                response: 500,
                description: 'Unexpected error.'
            )
        ]
    )]
    #[Route('/api/content', 'content.create', defaults: ['auth_required' => false], methods: ['POST'])]
    public function create(Request $request): Response
    {
        $id = $this->customEntityRepository->create($request->request->all());
        $entity = $this->customEntityRepository->read(null, $id);
        return $this->jsonResponseType->createDetailResponse($entity, $id, $this->class, Response::HTTP_CREATED);
    }

    #[OA\Patch(
        path: '/api/content/{id}',
        operationId: '',
        description: 'Create content',
        summary: '',
        requestBody: new OA\RequestBody(request: 'das', required: true, content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'isoCode', required: ['true'], type: 'string', maxLength: 2, example: 'de'),
                new OA\Property(property: 'title', required: ['true'], type: 'string', maxLength: 100, example: 'Impressum'),
                new OA\Property(property: 'text', required: ['true'], type: 'string', example: 'Example text to show'),
            ]
        )),
        tags: ['Content'],
        parameters: [new OA\PathParameter(name: 'id', required: true)],
        responses: [
        new OA\Response(
            response: 201,
            description: 'Create content successfully',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'data', properties: [
                        new OA\Property(property: null, properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'isoCode', type: 'string'),
                            new OA\Property(property: 'title', type: 'string'),
                            new OA\Property(property: 'text', type: 'string'),
                            new OA\Property(property: 'createdAt', type: 'string'),
                            new OA\Property(property: 'updatedAt', type: 'string'),
                        ])
                    ])
                ]
            )
        ),
        new OA\Response(
            response: 401,
            description: 'Authorization information is missing or invalid.'
        ),
        new OA\Response(
            response: 500,
            description: 'Unexpected error.'
        )
        ]
    )]
    #[Route('/api/content/{id}', 'content.update', defaults: ['auth_required' => false], methods: ['PATCH'])]
    public function update(Request $request, int $id): Response
    {
        $id = $this->customEntityRepository->update($request->request->all(), $id);
        $entity = $this->customEntityRepository->read(null, $id);
        return $this->jsonResponseType->createDetailResponse($entity, $id, $this->class);
    }

    #[OA\Delete(
        path: '/api/content/{id}',
        operationId: '',
        description: 'Delete content for one entity',
        summary: '',
        tags: ['Content'],
        parameters: [new OA\PathParameter(name: 'id', required: true)],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Delete content successfully'
            ),
            new OA\Response(
                response: 400,
                description: 'Bad request. Content ID must be an integer and larger than 0'
            ),
            new OA\Response(
                response: 401,
                description: 'Authorization information is missing or invalid.'
            ),
            new OA\Response(
                response: 403,
                description: 'Not found. Resource could not be found by given id.'
            ),
            new OA\Response(
                response: 500,
                description: 'Unexpected error.'
            )
        ]
    )]
    #[Route('/api/content/{id}', 'content.delete', defaults: ['auth_required' => false], methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $this->customEntityRepository->delete($id);
        return $this->jsonResponseType->createNoContentResponse();
    }
}
