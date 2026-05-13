<?php
require 'vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Tes identifiants
$dsn = 'gmail+smtp://houimlilouay6@gmail.com:mrnzkwnlstypnndv@default';

try {
    $transport = Transport::fromDsn($dsn);
    $mailer = new Mailer($transport);
    
    $email = (new Email())
        ->from('houimlilouay6@gmail.com')
        ->to('houimlilouay6@gmail.com')
        ->subject('🧪 Test direct')
        ->text('Si tu vois ce message, Gmail fonctionne !');
    
    $mailer->send($email);
    
    echo "✅ Email envoyé ! Vérifie ta boîte Gmail.\n";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}