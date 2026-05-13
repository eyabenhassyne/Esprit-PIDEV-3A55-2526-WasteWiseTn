<?php

namespace App\Service;

use App\Entity\ZonePolluee;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;
    
    public function __construct()
    {
        // Même DSN que dans test_gmail.php
        $transport = Transport::fromDsn('gmail+smtp://houimlilouay6@gmail.com:mrnzkwnlstypnndv@default');
        $this->mailer = new Mailer($transport);
    }

    public function sendZoneAlert(ZonePolluee $zone): void
    {
        $email = (new Email())
            ->from('houimlilouay6@gmail.com')
            ->to('houimlilouay6@gmail.com')
            ->subject('🌱 Nouvelle zone: ' . $zone->getNomZone())
            ->html("
                <h2>Nouvelle zone polluée</h2>
                <p><strong>Nom:</strong> {$zone->getNomZone()}</p>
                <p><strong>Niveau:</strong> {$zone->getNiveauPollution()}/10</p>
                <p><strong>GPS:</strong> {$zone->getCoordonneesGps()}</p>
                <p><strong>Date:</strong> {$zone->getDateIdentification()->format('d/m/Y H:i')}</p>
            ");
        
        $this->mailer->send($email);
    }

    public function sendCriticalAlert(ZonePolluee $zone): void
    {
        $email = (new Email())
            ->from('houimlilouay6@gmail.com')
            ->to('houimlilouay6@gmail.com')
            ->subject('🔴 CRITIQUE: ' . $zone->getNomZone())
            ->html("
                <h2 style='color: red;'>🔴 ALERTE CRITIQUE</h2>
                <p><strong>Nom:</strong> {$zone->getNomZone()}</p>
                <p><strong style='color: red;'>Niveau: {$zone->getNiveauPollution()}/10</strong></p>
                <p><strong>GPS:</strong> {$zone->getCoordonneesGps()}</p>
                <p><strong>Date:</strong> {$zone->getDateIdentification()->format('d/m/Y H:i')}</p>
            ");
        
        $this->mailer->send($email);
    }
}