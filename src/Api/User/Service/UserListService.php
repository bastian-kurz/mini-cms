<?php

declare(strict_types=1);

namespace App\Api\User\Service;

use App\Core\ListServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserListService implements ListServiceInterface
{
    private HttpClientInterface $client;

    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchList(): string
    {
        $response = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/users');

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return '';
        }

        return $response->getContent();
    }

    public function convert(string $data): array
    {
        return $this->serializer->deserialize($data, 'App\Api\User\UserObject[]', 'json');
    }
}