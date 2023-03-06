<?php

declare(strict_types=1);

namespace App\OAuth;

use League\OAuth2\Server\Entities\UserEntityInterface;

class User implements UserEntityInterface
{
    private int $identifier;

    public function __construct(int $identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }
}
