<?php

declare(strict_types=1);

namespace App\OAuth\Scope;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

class AdminScope implements ScopeEntityInterface
{
    public const IDENTIFIER = 'ROLE_ADMIN';

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function jsonSerialize(): string
    {
        return self::IDENTIFIER;
    }
}
