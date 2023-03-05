<?php

declare(strict_types=1);

namespace App\Tests\OAuth;

use App\OAuth\AccessToken;
use App\OAuth\Client\ApiClient;
use App\OAuth\Scope\AdminScope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessTokenTest extends WebTestCase
{
    public function testAccessToken(): void
    {
        $client = new ApiClient('test', true, 'foo');
        $accessToken = new AccessToken($client, [], null);

        $this->assertNull($accessToken->getUserIdentifier());
        $this->assertInstanceOf(ClientEntityInterface::class, $accessToken->getClient());
        $this->assertEmpty($accessToken->getScopes());

        $accessToken->setUserIdentifier('foo');
        $accessToken->setClient($client);
        $accessToken->addScope(new AdminScope());

        $this->assertInstanceOf(ClientEntityInterface::class, $accessToken->getClient());
        $this->assertEquals('foo', $accessToken->getUserIdentifier());
        $this->assertNotEmpty($accessToken);
    }
}
