<?php

declare(strict_types=1);

namespace App\OAuth;

use App\OAuth\Scope\AdminScope;
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
        $hasWrite = false;

        if (!$hasWrite) {
            $scopes = $this->removeScopes($scopes, AdminScope::class);
        }
        //@Todo user permission correct

        return $this->uniqueScopes($scopes);
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
