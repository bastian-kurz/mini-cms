<?php

declare(strict_types=1);

namespace App\Tests\Api\User\Service;

use App\Api\User\Service\UserListService;
use App\Api\User\UserObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserListServiceTest extends WebTestCase
{
    private Container $container;

    private UserListService $userListService;

    public function setUp(): void
    {
        parent::setUp();
        $this->container = static::getContainer();
        $this->userListService = $this->container->get(UserListService::class);
    }

    /** @test */
    public function fetchList(): void
    {
        $json = $this->userListService->fetchList();
        $this->assertTrue(strlen($json) > 0);

        $data = json_decode($json, true);
        $this->assertIsArray($data);
    }

    /** @test  */
    public function convert(): void
    {
        $json = $this->userListService->fetchList();
        $objects = $this->userListService->convert($json);

        $this->assertIsArray($objects);

        foreach ($objects as $object) {
            $this->assertInstanceOf(UserObject::class, $object);
        }
    }
}
