<?php

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ToggleActiveForbiddenTest extends WebTestCase
{
    public function testToggleActiveIsNotAccessibleForNonAdmin(): void
    {
        $client = static::createClient();

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $em->createQuery('DELETE FROM App\Entity\User u')->execute();

        $citizen = (new User())
            ->setEmail('cit@x.tn')
            ->setNom('C')
            ->setPrenom('T')
            ->setPassword('hash')
            ->setType(User::TYPE_CITIZEN)
            ->setIsActive(true);

        $target = (new User())
            ->setEmail('target@x.tn')
            ->setNom('T')
            ->setPrenom('U')
            ->setPassword('hash')
            ->setType(User::TYPE_CITIZEN)
            ->setIsActive(true);

        $em->persist($citizen);
        $em->persist($target);
        $em->flush();

        $client->loginUser($citizen);

        $client->request('POST', '/admin/user/' . $target->getId() . '/toggle-active', server: [
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $status = $client->getResponse()->getStatusCode();

        // ✅ cas 1: sécurité admin => 403
        if ($status === 403) {
            self::assertResponseStatusCodeSame(403);
            return;
        }

        // ✅ cas 2: interception 2FA => 302 vers la page 2FA
        if ($status === 302) {
            $location = $client->getResponse()->headers->get('Location') ?? '';
            self::assertStringContainsString('/profile/2fa/manual', $location);
            return;
        }

        self::fail('Expected 403 Forbidden or 302 TwoFactor redirect, got ' . $status);
    }
}