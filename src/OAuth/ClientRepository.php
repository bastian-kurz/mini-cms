<?php

declare(strict_types=1);

namespace App\OAuth;

use App\OAuth\Client\ApiClient;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ClientRepository implements ClientRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws OAuthServerException
     * @throws Exception
     */
    public function getClientEntity($clientIdentifier): ?ClientEntityInterface
    {
        $data = $this->getByEmail($clientIdentifier);
        $client = new ApiClient($clientIdentifier, false, $data['email']);
        $client->setUserIdentifier($data['id']);

        return $client;
    }

    /**
     * @throws OAuthServerException
     * @throws Exception
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        if ($grantType === 'client_credentials' && $clientSecret !== null) {
            $data = $this->getByEmail($clientIdentifier);

            if ($data['secret'] === null) {
                throw new UnauthorizedHttpException('Challenge');
            }

            return password_verify($clientSecret, $data['secret']);
        }

        throw OAuthServerException::unsupportedGrantType();
    }

    /**
     * @throws Exception
     * @throws OAuthServerException
     * @return array<string, mixed>
     */
    private function getByEmail(string $clientIdentifier): array
    {
        $res = $this->connection->createQueryBuilder()
            ->select(['id', 'email', 'secret', 'scopes'])
            ->from('user')
            ->where('email = :email')
            ->setParameter('email', $clientIdentifier)
            ->executeQuery()
            ->fetchAssociative();

        if (!$res) {
            throw OAuthServerException::invalidCredentials();
        }

        return $res;
    }
}
