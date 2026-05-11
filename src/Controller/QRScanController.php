<?php

namespace App\Controller;

use App\Entity\QRScan;
use App\Repository\ZonePollueeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QRScanController extends AbstractController
{
    #[Route('/scan/{id}', name: 'app_qr_scan')]
    public function track(int $id, ZonePollueeRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $zone = $repository->find($id);
        
        if (!$zone) {
            return new Response('Zone not found', 404);
        }
        
        try {
            $scan = new QRScan();
            $scan->setZone($zone);
            $scan->setScannedAt(new \DateTime()); // Using DateTime, NOT DateTimeImmutable
            $scan->setIpAddress($request->getClientIp());
            $scan->setCountry('Tunisia');
            
            // Detect device
            $userAgent = $request->headers->get('User-Agent');
            $deviceType = 'Unknown';
            if (strpos($userAgent, 'iPhone') !== false) $deviceType = 'iPhone';
            elseif (strpos($userAgent, 'Android') !== false) $deviceType = 'Android';
            $scan->setDeviceType($deviceType);
            
            $entityManager->persist($scan);
            $entityManager->flush();
            
            // Redirect to Google Maps
            $coords = explode(',', $zone->getCoordonneesGps());
            $lat = trim($coords[0]);
            $lng = trim($coords[1]);
            
            return $this->redirect("https://www.google.com/maps/search/?api=1&query={$lat},{$lng}");
            
        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), 500);
        }
    }
}