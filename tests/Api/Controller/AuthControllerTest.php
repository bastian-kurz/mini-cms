<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ContainerInterface $container;
    private Connection $connection;

    private int $userId;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = static::getContainer();
        $this->connection = $this->container->get('doctrine.dbal.default_connection');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testE2e(): void
    {
        $this->createUser();
        $this->unauthorized();
        $this->authorized();
    }

    /**
     * @throws Exception
     */
    private function createUser(): void
    {
        $this->connection->createQueryBuilder()
            ->insert('user')
            ->values([
                'email' => ':email',
                'password' => ':password',
                'scopes' => ':scopes',
                'created_at' => ':createdAt'
            ])
            ->setParameters([
                'email' => 'test@test.de',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'scopes' => 'ROLE_ADMIN,ROLE_USER',
                'createdAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s')
            ])
            ->executeQuery();
    }

    private function unauthorized(): void
    {
        $this->client->jsonRequest(
            'POST',
            '/api/oauth/token',
            [
                'grant_type' => 'password',
                'client_id' => 'administration',
                'password' => 'foo',
                'username' => 'bar'
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    private function authorized(): void
    {
        $this->client->jsonRequest(
            'POST',
            '/api/oauth/token',
            [
                'grant_type' => 'password',
                'client_id' => 'administration',
                'password' => '12345',
                'username' => 'test@test.de'
            ]
        );

        $token = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token_type', $token);
        $this->assertArrayHasKey('expires_in', $token);
        $this->assertArrayHasKey('access_token', $token);
        $this->assertArrayHasKey('refresh_token', $token);
        $this->assertArrayHasKey('scopes', $token);
        $this->assertTrue($token['isAdmin']);
    }

    /**
     * @throws Exception
     */
    public function tearDown(): void
    {
        $this->connection->createQueryBuilder()
            ->delete('user')
            ->where('email = :email')
            ->setParameter('email', 'test@test.de')
            ->executeQuery();
        parent::tearDown();
    }
}
