<?php

namespace App\Tests\Entity;

use App\Entity\ReponseOffre;
use PHPUnit\Framework\TestCase;

final class ReponseOffreTest extends TestCase
{
    public function testSetStatutNormalizesValidatedValues(): void
    {
        $reponse = new ReponseOffre();
        $reponse->setStatut('VALIDEE');

        self::assertSame(ReponseOffre::STATUT_VALIDE, $reponse->getStatut());
    }

    public function testSetStatutNormalizesRejectedValues(): void
    {
        $reponse = new ReponseOffre();
        $reponse->setStatut('rejetee');

        self::assertSame(ReponseOffre::STATUT_REFUSE, $reponse->getStatut());
    }

    public function testSetStatutFallsBackToPendingForUnknownValue(): void
    {
        $reponse = new ReponseOffre();
        $reponse->setStatut('inconnu');

        self::assertSame(ReponseOffre::STATUT_EN_ATTENTE, $reponse->getStatut());
        self::assertTrue($reponse->isEnAttente());
    }

    public function testCanTransitionToAllowsOnlyPendingToValidatedOrRejected(): void
    {
        $reponse = new ReponseOffre();
        $reponse->setStatut('en_attente');

        self::assertTrue($reponse->canTransitionTo('validee'));
        self::assertTrue($reponse->canTransitionTo('refusee'));
        self::assertFalse($reponse->canTransitionTo('en attente'));

        $reponse->setStatut('valide');
        self::assertFalse($reponse->canTransitionTo('refuse'));
    }
}
