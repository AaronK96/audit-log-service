<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DashboardControllerTest extends WebTestCase
{
    public function testDashboardCanBeLoaded(): void
    {
        $client = static::createClient();

        $client->request('GET', '/dashboard');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Audit Log Dashboard');
        self::assertSelectorTextContains('body', 'Filter');
        self::assertSelectorTextContains('body', 'Letzte Audit Events');
        self::assertSelectorExists('table');
    }

    public function testDashboardAcceptsFilters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/dashboard?actorId=admin-1&action=USER_CREATED&page=1&limit=10');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('input[name="actorId"]');
        self::assertSelectorExists('input[name="action"]');
        self::assertSelectorExists('input[name="correlationId"]');
    }
}
