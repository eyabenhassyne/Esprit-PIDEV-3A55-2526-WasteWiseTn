<?php

namespace App\Tests\Functional\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FaceLoginInvalidPayloadTest extends WebTestCase
{
    public function testVerifyFaceRejectsInvalidPayload(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/face-login/verify', server: [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ], content: json_encode([
            'email' => '',          // invalide
            'embedding' => [],      // invalide (<64)
        ]));

        self::assertResponseStatusCodeSame(400);
    }
}