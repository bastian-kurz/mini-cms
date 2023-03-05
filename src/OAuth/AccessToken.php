<?php

declare(strict_types=1);

namespace App\OAuth;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

class AccessToken implements AccessTokenEntityInterface
{
    use EntityTrait;
    use RefreshTokenTrait;
    use AccessTokenTrait;

    private ClientEntityInterface $client;

    /** @var ScopeEntityInterface[] */
    private array $scopes;

    private mixed $userIdentifier;

    public function __construct(ClientEntityInterface $client, array $scopes, mixed $identifier = null)
    {
        $this->client = $client;
        $this->scopes = $scopes;
        $this->userIdentifier = $identifier;
    }

    public function getClient(): ClientEntityInterface
    {
        return $this->client;
    }

    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }

    public function addScope(ScopeEntityInterface $scope)
    {
        $this->scopes[] = $scope;
    }

    public function getUserIdentifier(): mixed
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(mixed $identifier): void
    {
        $this->userIdentifier = $identifier;
    }
}
