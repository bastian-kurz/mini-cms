<?php

declare(strict_types=1);

namespace App\Tests\OAuth\Scope;

use App\OAuth\Scope\AdminScope;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminScopeTest extends WebTestCase
{
    public function testAdminScope(): void
    {
        $scope = new AdminScope();
        $this->assertEquals(AdminScope::IDENTIFIER, $scope->getIdentifier());
        $this->assertEquals(AdminScope::IDENTIFIER, $scope->jsonSerialize());
    }
}
