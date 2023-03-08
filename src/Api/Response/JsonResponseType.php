<?php

namespace App\Api\Response;

use App\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonResponseType
{
    /**
     * @throws ExceptionInterface
     */
    public function createDetailResponse(
        ?EntityInterface $entity,
        int $id,
        string $class,
        int $statusCode = Response::HTTP_OK
    ): Response {
        if ($entity === null) {
            throw new NotFoundHttpException(sprintf("Entity %s with id: %d not found!", $class, $id));
        }

        $decoded = $this->getDecodedEntity($entity);

        $response = [
            'data' => $decoded
        ];

        return new JsonResponse($response, $statusCode);
    }

    /**
     * @throws ExceptionInterface
     */
    public function createListResponse(iterable $entities, int $statusCode = Response::HTTP_OK): Response
    {
        $decoded = [];

        if (count($entities) > 0) {
            foreach ($entities as $entity) {
                $decoded[] = $this->getDecodedEntity($entity);
            }
        }

        $response = [
            'total' => count($entities),
            'page' => 1,
            'data' => $decoded
        ];

        return new JsonResponse($response, $statusCode);
    }

    public function createNoContentResponse(): Response
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws ExceptionInterface
     */
    private function getDecodedEntity(EntityInterface $entity): array
    {
        $normalizer = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizer, []);
        return $serializer->normalize($entity);
    }
}
