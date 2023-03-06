<?php

declare(strict_types=1);

namespace App\OAuth\Client;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;

class ApiClient implements ClientEntityInterface
{
    use ClientTrait;

    private bool $writeAccess;

    private string $identifier;

    private ?string $userIdentifier;

    public function __construct(string $identifier, bool $writeAccess, string $name = '')
    {
        $this->identifier = $identifier;
        $this->writeAccess = $writeAccess;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isWriteAccess(): bool
    {
        return $this->writeAccess;
    }

    public function setWriteAccess(bool $writeAccess): void
    {
        $this->writeAccess = $writeAccess;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(?string $userIdentifier): void
    {
        $this->userIdentifier = $userIdentifier;
    }

    public function isConfidential(): bool
    {
        return true;
    }
}
