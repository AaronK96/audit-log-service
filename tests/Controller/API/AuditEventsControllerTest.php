<?php

namespace App\Tests\Controller\API\;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuditEventsControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/a/p/i/audit/events');

        self::assertResponseIsSuccessful();
    }
}
