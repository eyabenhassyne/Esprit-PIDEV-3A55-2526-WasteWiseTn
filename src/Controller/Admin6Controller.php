<?php

namespace App\Controller;

use App\Repository\IndicateurImpactRepository;
use App\Repository\ZonePollueeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Admin6Controller extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboard(
        ZonePollueeRepository $zoneRepository,
        IndicateurImpactRepository $indicateurRepository
    ): Response {
        // VERSION OPTIMISÉE - SANS ?? INUTILE
        $zones = $zoneRepository->findAll();
        $indicateurs = $indicateurRepository->findAll();
        
        return $this->render('admin/dashboard.html.twig', [
            'zones' => $zones,
            'indicateurs' => $indicateurs,
        ]);
    }
}