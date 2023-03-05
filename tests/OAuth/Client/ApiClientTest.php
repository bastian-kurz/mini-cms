<?php

declare(strict_types=1);

namespace App\Tests\OAuth\Client;

use App\OAuth\Client\ApiClient;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiClientTest extends WebTestCase
{
    public function testApiClient(): void
    {
        $client = new ApiClient('test', true, 'foo');
        $client->setUserIdentifier('123456789');
        $this->assertEquals('123456789', $client->getUserIdentifier());
        $this->assertEquals('test', $client->getIdentifier());
        $this->assertTrue($client->isWriteAccess());
        $this->assertTrue($client->isConfidential());
        $this->assertEquals('foo', $client->getName());
    }
}
