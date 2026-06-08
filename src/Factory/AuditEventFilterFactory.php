<?php

namespace App\Factory;

use App\Dto\AuditEventFilter;
use Symfony\Component\HttpFoundation\Request;

final class AuditEventFilterFactory
{
    public function fromRequest(Request $request): AuditEventFilter
    {
        $filter = new AuditEventFilter();

        $filter->actorId = $request->query->get('actorId');
        $filter->action = $request->query->get('action');
        $filter->resourceType = $request->query->get('resourceType');
        $filter->resourceId = $request->query->get('resourceId');
        $filter->serviceName = $request->query->get('serviceName');
        $filter->correlationId = $request->query->get('correlationId');

        if ($request->query->get('from')) {
            $filter->from = new \DateTimeImmutable($request->query->get('from'));
        }

        if ($request->query->get('to')) {
            $filter->to = new \DateTimeImmutable($request->query->get('to'));
        }

        $filter->page = max(1, $request->query->getInt('page', 1));
        $filter->limit = min(100, max(1, $request->query->getInt('limit', 20)));

        return $filter;
    }
}