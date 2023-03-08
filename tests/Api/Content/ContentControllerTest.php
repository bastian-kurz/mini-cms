<?php

declare(strict_types=1);

namespace App\Tests\Api\Content;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContentControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    private ?int $contentId;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    private function payload(): array
    {
        return [
            'isoCode' => 'de',
            'title' => 'Unit-Test',
            'text' => 'Unit-Test text'
        ];
    }

    /** @test  */
    public function e2e(): void
    {
        $this->create();
        $this->read();
        $this->list();
        $this->update();
        $this->delete();
    }

    private function create(): void
    {
        $this->client->jsonRequest('POST', '/api/content', $this->payload());
        $responseData = json_decode($this->client->getResponse()->getContent(), true)['data'];
        $this->contentId = $responseData['id'];

        foreach ($this->payload() as $key => $value) {
            $this->assertArrayHasKey($key, $responseData);
            $this->assertEquals($value, $responseData[$key]);
        }

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    private function read(): void
    {
        $this->client->request('GET', '/api/content/' . $this->contentId);
        $responseData = json_decode($this->client->getResponse()->getContent(), true)['data'];

        foreach ($this->payload() as $key => $value) {
            $this->assertArrayHasKey($key, $responseData);
            $this->assertEquals($value, $responseData[$key]);
        }

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    private function list(): void
    {
        $this->client->request('GET', '/api/content');
        $responseData = json_decode($this->client->getResponse()->getContent(), true)['data'];

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertIsArray($responseData);
        $this->assertTrue(count($responseData) > 0);
    }

    private function update(): void
    {
        $updateData = ['isoCode' => 'ch', 'title' => 'Schweiz'];
        $this->client->jsonRequest('PATCH', '/api/content/' . $this->contentId, $updateData);
        $responseData = json_decode($this->client->getResponse()->getContent(), true)['data'];

        $this->assertEquals($this->contentId, $responseData['id']);

        foreach ($updateData as $key => $value) {
            $this->assertArrayHasKey($key, $responseData);
            $this->assertEquals($value, $responseData[$key]);
        }

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
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
