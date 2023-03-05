<?php

declare(strict_types=1);

namespace App\Tests\OAuth\Scope;

use App\OAuth\Scope\UserScope;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserScopeTest extends WebTestCase
{
    public function testUserScope(): void
    {
        $scope = new UserScope();
        $this->assertEquals(UserScope::IDENTIFIER, $scope->getIdentifier());
        $this->assertEquals(UserScope::IDENTIFIER, $scope->jsonSerialize());
    }
}
