<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuditEventsControllerTest extends WebTestCase
{
    private const API_KEY = 'audit_test_7f4c9a2b1e8d5f3c6a9b2e1d4f8c7a3';

    public function testGetAuditEventsRequiresApiKey(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/audit-events');

        self::assertResponseStatusCodeSame(401);
    }

    public function testGetAuditEventsWorksWithApiKey(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/audit-events', [], [], [
            'HTTP_X_API_KEY' => self::API_KEY,
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
    }

    public function testPostAuditEventRequiresApiKey(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/audit-events',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'actorId' => 'admin-1',
                'action' => 'USER_CREATED',
                'resourceType' => 'User',
                'resourceId' => 'user-101',
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(401);
    }

    public function testPostAuditEventCreatesEvent(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/audit-events',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X_API_KEY' => self::API_KEY,
            ],
            json_encode([
                'actorId' => 'admin-1',
                'action' => 'USER_CREATED',
                'resourceType' => 'User',
                'resourceId' => 'user-101',
                'serviceName' => 'user-service',
                'correlationId' => 'corr-test-001',
                'metadata' => [
                    'email' => 'john.doe@example.com',
                    'role' => 'USER',
                ],
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(201);
        self::assertResponseHeaderSame('content-type', 'application/json');
    }

    public function testPostAuditEventValidatesRequiredFields(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/audit-events',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X_API_KEY' => self::API_KEY,
            ],
            json_encode([
                'actorId' => '',
                'action' => '',
                'resourceType' => '',
                'resourceId' => '',
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(422);
    }

    public function testGetAuditEventsWithFilters(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/audit-events?action=USER_CREATED&page=1&limit=10', [], [], [
            'HTTP_X_API_KEY' => self::API_KEY,
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
    }
}
