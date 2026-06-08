<?php

namespace App\Repository;

use App\Entity\AuditEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Dto\AuditEventFilter;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuditEvent>
 */
class AuditEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditEvent::class);
    }

    public function search(AuditEventFilter $filter): array
    {
        $qb = $this->createQueryBuilder('e')
            ->orderBy('e.createdAt', 'DESC');

        if ($filter->actorId) {
            $qb->andWhere('e.actorId = :actorId')
                ->setParameter('actorId', $filter->actorId);
        }

        if ($filter->action) {
            $qb->andWhere('e.action = :action')
                ->setParameter('action', $filter->action);
        }

        if ($filter->resourceType) {
            $qb->andWhere('e.resourceType = :resourceType')
                ->setParameter('resourceType', $filter->resourceType);
        }

        if ($filter->resourceId) {
            $qb->andWhere('e.resourceId = :resourceId')
                ->setParameter('resourceId', $filter->resourceId);
        }

        if ($filter->serviceName) {
            $qb->andWhere('e.serviceName = :serviceName')
                ->setParameter('serviceName', $filter->serviceName);
        }

        if ($filter->correlationId) {
            $qb->andWhere('e.correlationId = :correlationId')
                ->setParameter('correlationId', $filter->correlationId);
        }

        if ($filter->from) {
            $qb->andWhere('e.createdAt >= :from')
                ->setParameter('from', $filter->from);
        }

        if ($filter->to) {
            $qb->andWhere('e.createdAt <= :to')
                ->setParameter('to', $filter->to);
        }

        $qb->setFirstResult(($filter->page - 1) * $filter->limit)
           ->setMaxResults($filter->limit);

        $paginator = new Paginator($qb);

        return [
            'items' => iterator_to_array($paginator),
            'page' => $filter->page,
            'limit' => $filter->limit,
            'total' => count($paginator),
        ];
    }
}
