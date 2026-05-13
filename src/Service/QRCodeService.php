<?php

namespace App\Service;

use App\Entity\ZonePolluee;
use Symfony\Component\HttpFoundation\Response;

class QRCodeService
{
    /**
     * Generate QR code with scan tracking (UPDATED VERSION)
     */
    public function generateColoredZoneQR(ZonePolluee $zone, int $size = 300): string
    {
        // Get your computer's local IP (CHANGE THIS TO YOUR IP)
       $yourIP = '10.37.146.40'; // ← YOUR ACTUAL IP
        
        // Use scan tracking URL instead of direct Google Maps
        $trackingUrl = "http://{$yourIP}:8000/scan/" . $zone->getId();
        
        // Choose color based on pollution level
        $color = '000000';
        if ($zone->getNiveauPollution() >= 7) {
            $color = 'dc3545';
        } elseif ($zone->getNiveauPollution() >= 4) {
            $color = 'ffc107';
        } else {
            $color = '28a745';
        }
        
        $apiUrl = 'https://quickchart.io/qr?text=' . urlencode($trackingUrl) . 
                  '&size=' . $size . 
                  '&dark=' . $color;
        
        $imageData = file_get_contents($apiUrl);
        return base64_encode($imageData);
    }
    
    public function createDownloadResponse(ZonePolluee $zone, int $size = 500): Response
    {
        $qrCodeData = $this->generateColoredZoneQR($zone, $size);
        $imageData = base64_decode($qrCodeData);
        
        $response = new Response($imageData);
        $response->headers->set('Content-Type', 'image/png');
        $response->headers->set('Content-Disposition', 'attachment; filename="zone-' . $zone->getId() . '-qr.png"');
        
        return $response;
    }
}