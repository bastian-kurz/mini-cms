<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /** @test */
    public function e2e()
    {
        $this->client->jsonRequest('GET', '/api/_info/openapi3.json');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('openapi', $data);
        $this->assertArrayHasKey('paths', $data);
        $this->assertArrayHasKey('/oauth/token', $data['paths']);
    }
}
