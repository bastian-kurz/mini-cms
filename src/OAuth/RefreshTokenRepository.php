<?php

declare(strict_types=1);

namespace App\OAuth;

use App\Defaults;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use League\Bundle\OAuth2ServerBundle\Entity\RefreshToken;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    /**
     * @throws Exception
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $timeZone = new DateTimeZone(Defaults::timeZone->value);
        $this->connection->createQueryBuilder()
            ->insert('refresh_token')
            ->values([
                'user_id' => ':userId',
                'token_id' => ':tokenId',
                'issued_at' => ':issuedAt',
                'expires_at' => ':expiresAt'
            ])
            ->setParameters([
                'userId' => $refreshTokenEntity->getAccessToken()->getUserIdentifier(),
                'tokenId' => $refreshTokenEntity->getIdentifier(),
                'issuedAt' => (new DateTimeImmutable(timezone: $timeZone))->format(Defaults::storageDateTimeFormat->value),
                'expiresAt' => $refreshTokenEntity->getExpiryDateTime()->setTimezone($timeZone)->format(Defaults::storageDateTimeFormat->value)
            ])
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function revokeRefreshToken($tokenId): void
    {
        $this->connection->createQueryBuilder()
            ->delete('refresh_token')
            ->where('token_id = :tokenId')
            ->setParameter('tokenId', $tokenId)
            ->executeQuery()
            ->fetchAssociative();

        $this->cleanUpExpiredRefreshTokens();
    }

    /**
     * @throws Exception
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        $refreshToken = $this->connection->createQueryBuilder()
            ->select(['token_id'])
            ->from('refresh_token')
            ->where('token_id = :tokenId')
            ->setParameter('tokenId', $tokenId)
            ->executeQuery()
            ->fetchAssociative();

        $this->cleanUpExpiredRefreshTokens();

        //no token found, token is invalid
        if (!$refreshToken) {
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function revokeRefreshTokenForUser(string $id): void
    {
        $this->connection->createQueryBuilder()
            ->delete('refresh_token')
            ->where('user_id = :userId')
            ->setParameter('userId', $id)
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    private function cleanUpExpiredRefreshTokens(): void
    {
        $now = (new DateTimeImmutable())->format(Defaults::storageDateTimeFormat->value);

        $this->connection->createQueryBuilder()
            ->delete('refresh_token')
            ->where('expires_at < :now')
            ->setParameter('now', $now)
            ->executeQuery();
    }
}
