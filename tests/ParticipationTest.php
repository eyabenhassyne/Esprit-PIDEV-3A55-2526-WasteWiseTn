<?php

namespace App\Tests;

use App\Entity\Participation;
use App\Entity\Evenement;
use PHPUnit\Framework\TestCase;

class ParticipationTest extends TestCase
{
    // 1. Test mta3 el initialisation (el constructor mte3ek)
    public function testInitialisation(): void
    {
        $participation = new Participation();
        
        // Thabbet elli el dateInscription t-7attet wa7edha l-youm kima fil constructor
        $this->assertInstanceOf(\DateTimeInterface::class, $participation->getDateInscription());
        $this->assertEquals((new \DateTime())->format('Y-m-d'), $participation->getDateInscription()->format('Y-m-d'));
        
        // El bakia lezem ykounou null
        $this->assertNull($participation->getNomCitoyen());
        $this->assertNull($participation->getEvenement());
    }

    // 2. Test mta3 el Setters w el Getters (Nom w Evenement)
    public function testParticipationAttributes(): void
    {
        $participation = new Participation();
        $evenement = new Evenement();
        
        $participation->setNomCitoyen("Skander")
                      ->setEvenement($evenement);

        $this->assertEquals("Skander", $participation->getNomCitoyen());
        $this->assertSame($evenement, $participation->getEvenement());
    }

    // 3. Test mta3 el Date (Manuel)
    public function testSetDateInscription(): void
    {
        $participation = new Participation();
        $date = new \DateTime('2024-01-01');
        
        $participation->setDateInscription($date);
        $this->assertEquals($date, $participation->getDateInscription());
    }
}