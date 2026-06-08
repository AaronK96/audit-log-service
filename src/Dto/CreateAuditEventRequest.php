<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateAuditEventRequest

{

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $actorId;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $action;

    #[Assert\NotBlank]
    public string $resourceType;

    #[Assert\NotBlank]
    public string $resourceId;

    public ?string $serviceName = null;

    public ?string $correlationId = null;

    public array $metadata = [];

}