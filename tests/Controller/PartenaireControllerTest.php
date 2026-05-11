<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PartenaireControllerTest extends WebTestCase
{
    public function testIndexRedirectsToDashboard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/partenaire');

        self::assertResponseRedirects('/partenaire/dashboard');
        $client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
