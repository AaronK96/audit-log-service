<?php

namespace App\Dto;

final class AuditEventFilter
{
    public ?string $actorId = null;

    public ?string $action = null;

    public ?string $resourceType = null;

    public ?string $resourceId = null;

    public ?string $serviceName = null;

    public ?string $correlationId = null;

    public ?\DateTimeImmutable $from = null;

    public ?\DateTimeImmutable $to = null;

    public int $page = 1;

    public int $limit = 20;
}