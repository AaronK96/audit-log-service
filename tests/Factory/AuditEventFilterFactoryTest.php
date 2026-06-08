<?php

namespace App\Tests\Factory;

use App\Factory\AuditEventFilterFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class AuditEventFilterFactoryTest extends TestCase
{
    public function testItCreatesFilterFromRequest(): void
    {
        $request = Request::create('/api/audit-events', 'GET', [
            'actorId' => 'admin-1',
            'action' => 'USER_CREATED',
            'resourceType' => 'User',
            'resourceId' => 'user-101',
            'serviceName' => 'user-service',
            'correlationId' => 'corr-1001',
            'from' => '2026-06-01 10:00:00',
            'to' => '2026-06-08 18:00:00',
            'page' => '2',
            'limit' => '50',
        ]);

        $filter = (new AuditEventFilterFactory())->fromRequest($request);

        self::assertSame('admin-1', $filter->actorId);
        self::assertSame('USER_CREATED', $filter->action);
        self::assertSame('User', $filter->resourceType);
        self::assertSame('user-101', $filter->resourceId);
        self::assertSame('user-service', $filter->serviceName);
        self::assertSame('corr-1001', $filter->correlationId);
        self::assertSame(2, $filter->page);
        self::assertSame(50, $filter->limit);
        self::assertInstanceOf(\DateTimeImmutable::class, $filter->from);
        self::assertInstanceOf(\DateTimeImmutable::class, $filter->to);
    }

    public function testItUsesDefaultPagination(): void
    {
        $request = Request::create('/api/audit-events');

        $filter = (new AuditEventFilterFactory())->fromRequest($request);

        self::assertSame(1, $filter->page);
        self::assertSame(20, $filter->limit);
    }

    public function testItLimitsInvalidPagination(): void
    {
        $request = Request::create('/api/audit-events', 'GET', [
            'page' => '-5',
            'limit' => '500',
        ]);

        $filter = (new AuditEventFilterFactory())->fromRequest($request);

        self::assertSame(1, $filter->page);
        self::assertSame(100, $filter->limit);
    }
}