<?php

namespace App\Controller;

use App\Repository\ZonePollueeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\InfoWindow;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(ZonePollueeRepository $zoneRepository): Response
    {
        $zones = $zoneRepository->findAll();
        
        // Create a new map
        $map = (new Map())
            ->center(new Point(36.8065, 10.1815))
            ->zoom(10);
        
        // Add markers for each zone
        foreach ($zones as $zone) {
            $coords = explode(',', $zone->getCoordonneesGps());
            if (count($coords) == 2) {
                $lat = (float) trim($coords[0]);
                $lng = (float) trim($coords[1]);
                
                $marker = new Marker(
                    position: new Point($lat, $lng),
                    title: $zone->getNomZone(),
                    infoWindow: new InfoWindow(
                        content: sprintf(
                            '<b>%s</b><br>Niveau: %s/10<br><a href="/zone-polluee/%s">Voir détails</a>',
                            $zone->getNomZone(),
                            $zone->getNiveauPollution(),
                            $zone->getId()
                        )
                    )
                );
                
                $map->addMarker($marker);
            }
        }
        
        return $this->render('map/index.html.twig', [
            'map' => $map
        ]);
    }
}