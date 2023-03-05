<?php

declare(strict_types=1);

namespace App\OAuth;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity): ?UserEntityInterface
    {
        $user = $this->connection->createQueryBuilder()
            ->select(['user_id', 'password'])
            ->from('user')
            ->where('email = :email')
            ->setParameter('email', $username)
            ->executeQuery()
            ->fetchAssociative();

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user['password'])) {
            return null;
        }

        return new User($user['id']);
    }
}
