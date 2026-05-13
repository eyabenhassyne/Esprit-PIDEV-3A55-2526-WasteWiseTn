<?php

namespace App\Controller;

use App\Repository\ZonePollueeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/zones', name: 'api_zones')]
    public function zones(ZonePollueeRepository $repository): JsonResponse
    {
        $zones = $repository->findAll();
        
        // Format the data for JavaScript
        $data = [];
        foreach ($zones as $zone) {
            $coords = explode(',', $zone->getCoordonneesGps());
            if (count($coords) == 2) {
                $data[] = [
                    'id' => $zone->getId(),
                    'nom' => $zone->getNomZone(),
                    'niveau' => $zone->getNiveauPollution(),
                    'lat' => (float) trim($coords[0]),
                    'lng' => (float) trim($coords[1]),
                ];
            }
        }
        
        return $this->json($data);
    }
}