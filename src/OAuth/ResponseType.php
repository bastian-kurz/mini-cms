<?php

declare(strict_types=1);

namespace App\OAuth;

use Doctrine\ORM\EntityManager;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse;

class ResponseType extends BearerTokenResponse
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array<string,mixed>
     */
    public function getExtraParams(AccessTokenEntityInterface $accessToken): array
    {
        return parent::getExtraParams($accessToken);
    }
}
