<?php

declare(strict_types=1);

namespace App\Tests\Api\User\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    /** @test */
    public function testList(): void
    {
        $this->client->jsonRequest('GET', '/api/user');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($data);
        $this->assertTrue(count($data) > 0);

        foreach($data as $key => $item) {
            $this->assertArrayHasKey('id', $data[$key]);
            $this->assertArrayHasKey('name', $data[$key]);
            $this->assertArrayHasKey('username', $data[$key]);
            $this->assertArrayHasKey('email', $data[$key]);
            $this->assertArrayHasKey('address', $data[$key]);
            $this->assertArrayHasKey('street', $data[$key]['address']);
            $this->assertArrayHasKey('zipcode', $data[$key]['address']);
            $this->assertArrayHasKey('suite', $data[$key]['address']);
            $this->assertArrayHasKey('city', $data[$key]['address']);
            $this->assertArrayHasKey('geo', $data[$key]['address']);
            $this->assertArrayHasKey('lat', $data[$key]['address']['geo']);
            $this->assertArrayHasKey('lng', $data[$key]['address']['geo']);
            $this->assertArrayHasKey('phone', $data[$key]);
            $this->assertArrayHasKey('website', $data[$key]);
            $this->assertArrayHasKey('company', $data[$key]);
            $this->assertArrayHasKey('name', $data[$key]['company']);
            $this->assertArrayHasKey('catchPhrase', $data[$key]['company']);
            $this->assertArrayHasKey('bs', $data[$key]['company']);

        }
    }
}