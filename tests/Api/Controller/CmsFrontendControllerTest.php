<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CmsFrontendControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    private ?int $contentId;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function payload(): array
    {
        return [
            'isoCode' => 'ch',
            'title' => 'Unit-Test',
            'text' => 'This is a simple text for unit tests'
        ];
    }

    /** @test  */
    public function e2e(): void
    {
        $this->create();
        $this->testControllerAction();
        $this->delete();
    }

    private function create(): void
    {
        $this->client->jsonRequest('POST', '/api/content', $this->payload());
        $responseData = json_decode($this->client->getResponse()->getContent(), true)['data'];
        $this->contentId = $responseData['id'];
    }

    private function testControllerAction(): void
    {
        $this->client->request('GET', '/fo/bar');
        $this->client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

        $this->client->request('GET', '/ch/Unit-Test');
        $response = $this->client->getResponse()->getContent();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('This is a simple text for unit tests', $response);
    }

    private function delete(): void
    {
        if ($this->contentId) {
            $this->client->jsonRequest(
                'DELETE',
                '/api/content/' . $this->contentId
            );
            $this->assertResponseIsSuccessful();
            $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
        }

        $this->contentId = null;
    }

    public function tearDown(): void
    {
        $this->delete();
        parent::tearDown();
    }
}
