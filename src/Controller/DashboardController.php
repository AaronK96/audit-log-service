<?php

namespace App\Controller;

use App\Dto\AuditEventFilter;
use App\Factory\AuditEventFilterFactory;
use App\Repository\AuditEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, AuditEventRepository $auditEventRepository, AuditEventFilterFactory $filterFactory): Response
    {
        $filter = $filterFactory->fromRequest($request);

        $result = $auditEventRepository->search($filter);

        return $this->render('dashboard/index.html.twig', [
            'events' => $result['items'],
            'page' => $result['page'],
            'limit' => $result['limit'],
            'total' => $result['total'],
        ]);
    }
}
