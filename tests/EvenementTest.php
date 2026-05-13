<?php

namespace App\Tests;

use App\Entity\Evenement;
use App\Entity\Participation;
use PHPUnit\Framework\TestCase;

class EvenementTest extends TestCase
{
    // 1. Test mta3 el Setters w el Getters (Lieu, Title, NomOrganisateur)
    public function testEvenementBasicAttributes(): void
    {
        $evenement = new Evenement();
        $date = new \DateTime('tomorrow');

        $evenement->setTitle("Nettoyage de Plage")
                  ->setDescription("Une action pour l'environnement.")
                  ->setDateHeure($date)
                  ->setNomOrganisateur("WasteWise TN")
                  ->setLieu("La Marsa");

        $this->assertEquals("Nettoyage de Plage", $evenement->getTitle());
        $this->assertEquals("Une action pour l'environnement.", $evenement->getDescription());
        $this->assertEquals($date, $evenement->getDateHeure());
        $this->assertEquals("WasteWise TN", $evenement->getNomOrganisateur());
        $this->assertEquals("La Marsa", $evenement->getLieu());
    }

    // 2. Test mta3 el Relation OneToMany (Participation)
    public function testEvenementParticipations(): void
    {
        $evenement = new Evenement();
        $participation = new Participation();

        // N-zidou participation
        $evenement->addParticipation($participation);
        $this->assertCount(1, $evenement->getParticipations());
        $this->assertTrue($evenement->getParticipations()->contains($participation));

        // N-na7iou participation
        $evenement->removeParticipation($participation);
        $this->assertCount(0, $evenement->getParticipations());
    }

    // 3. Test mta3 el __toString()
    public function testToString(): void
    {
        $evenement = new Evenement();
        $evenement->setTitle("Test Event");
        $this->assertEquals("Test Event", (string)$evenement);
    }
}