<?php

namespace App\Controller\Api;

use App\Dto\AuditEventFilter;
use App\Entity\AuditEvent;
use App\Dto\CreateAuditEventRequest;
use App\Factory\AuditEventFilterFactory;
use App\Repository\AuditEventRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

final class AuditEventsController extends AbstractController
{
    #[Route('/api/audit-events', name: 'api_audit_events', methods: ["GET"])]
    public function listAuditEvent(Request $request, AuditEventRepository $auditEventRepository, AuditEventFilterFactory $filterFactory): JsonResponse
    {
        $filter = $filterFactory->fromRequest($request);

        $result = $auditEventRepository->search($filter);

        return $this->json($result);
    }

    #[Route('/api/audit-events/{id}', name: 'api_audit_events_list', methods: ["GET"])]
    public function readAuditEvent(EntityManagerInterface $entityManager, $id): JsonResponse
    {
        $auditEvent = $entityManager->getRepository(AuditEvent::class)->findOneBy(['id' => $id]);
        
        if($auditEvent) {
            return $this->json($auditEvent);
        }

        return $this->json(['error' => 'Audit event not found'], Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/audit-events', name: 'api_audit_events_create', methods: ["POST"])]
    public function createAuditEvent(Request $request, EntityManagerInterface $entityManager, #[MapRequestPayload] CreateAuditEventRequest $dto): JsonResponse
    {
        $auditEvent = new AuditEvent();
        $auditEvent->setActorId($dto->actorId);
        $auditEvent->setAction($dto->action);
        $auditEvent->setResourceId($dto->resourceId);
        $auditEvent->setResourceType($dto->resourceType);
        $auditEvent->setServiceName($dto->serviceName ? $dto->serviceName : '');
        $auditEvent->setCorrelationId($dto->correlationId);
        $auditEvent->setMetadata($dto->metadata);
        $auditEvent->setCreatedAt(new DateTimeImmutable());
        $auditEvent->setIpAddress($request->getClientIp());
        $auditEvent->setUserAgent($request->headers->get('User-Agent'));

        $entityManager->persist($auditEvent);
        $entityManager->flush();

        return $this->json([
            'id' => $auditEvent->getId(),
            'createdAt' => $auditEvent->getCreatedAt(),
            'dto' => $dto
        ], Response::HTTP_CREATED);
    }
}
