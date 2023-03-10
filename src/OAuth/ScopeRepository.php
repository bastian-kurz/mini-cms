<?php

declare(strict_types=1);

namespace App\OAuth;

use App\OAuth\Scope\AdminScope;
use App\OAuth\Scope\UserScope;
use Doctrine\DBAL\Connection;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /** @var ScopeEntityInterface[] */
    private array $scopes;

    private Connection $connection;

    public function __construct(iterable $scopes, Connection $connection)
    {
        $this->connection = $connection;
        $scopeIndex = [];
        foreach ($scopes as $scope) {
            $scopeIndex[$scope->getIdentifier()] = $scope;
        }

        $this->scopes = $scopeIndex;
    }

    public function getScopeEntityByIdentifier($identifier): ?ScopeEntityInterface
    {
        return $this->scopes[$identifier] ?? null;
    }

    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null): array
    {
        $finalScopes = [];
        $dbScopes = $this->connection->createQueryBuilder()
            ->select('scopes')
            ->from('user')
            ->where('id = :userIdentifier')
            ->setParameter('userIdentifier', $userIdentifier)
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchOne();

        if ($dbScopes === null) {
            return $this->uniqueScopes($finalScopes);
        }

        if (strlen($dbScopes) > 0) {
            $dbScopes = array_flip(explode(',', $dbScopes));
        }

        if (array_key_exists(AdminScope::IDENTIFIER, $dbScopes)) {
            $finalScopes[] = new AdminScope();
        }

        if (array_key_exists(UserScope::IDENTIFIER, $dbScopes)) {
            $finalScopes[] = new UserScope();
        }

        return $this->uniqueScopes($finalScopes);
    }

    private function uniqueScopes(array $scopes): array
    {
        $uniqueScopes = [];

        foreach ($scopes as $scope) {
            $uniqueScopes[$scope->getIdentifier()] = $scope;
        }

        return array_values($uniqueScopes);
    }

    private function removeScopes(array $scopes, string $class): array
    {
        foreach ($scopes as $index => $scope) {
            if ($scope instanceof $class) {
                unset($scopes[$index]);
            }
        }

        return $scopes;
    }
}
