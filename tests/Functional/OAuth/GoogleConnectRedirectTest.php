<?php

namespace App\Tests\Functional\OAuth;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GoogleConnectRedirectTest extends WebTestCase
{
    public function testGoogleConnectStartRedirects(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connect/google');

        // doit être une redirection vers Google (ou vers une URL de login oauth)
        self::assertTrue($client->getResponse()->isRedirection());
    }
}