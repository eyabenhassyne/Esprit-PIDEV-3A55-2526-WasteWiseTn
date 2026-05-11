<?php

namespace App\Controller;

use App\Repository\QRScanRepository;
use App\Repository\ZonePollueeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QRDashboardController extends AbstractController
{
    #[Route('/qr-dashboard', name: 'app_qr_dashboard')]
    public function index(QRScanRepository $scanRepository, ZonePollueeRepository $zoneRepository): Response
    {
        $zones = $zoneRepository->findAll();
        $totalScans = $scanRepository->count([]);
        $recentScans = $scanRepository->findBy([], ['scannedAt' => 'DESC'], 10);
        
        // Stats per zone
        $zoneStats = [];
        foreach ($zones as $zone) {
            $zoneStats[$zone->getId()] = [
                'zone' => $zone,
                'count' => $scanRepository->count(['zone' => $zone]),
                'lastScan' => $scanRepository->findOneBy(['zone' => $zone], ['scannedAt' => 'DESC'])
            ];
        }
        
        return $this->render('qr_dashboard/index.html.twig', [
            'totalScans' => $totalScans,
            'recentScans' => $recentScans,
            'zoneStats' => $zoneStats,
        ]);
    }
}