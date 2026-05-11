<?php

namespace App\Tests\Service;

use App\Entity\ZonePolluee;
use App\Service\ZonePollueeManager;
use PHPUnit\Framework\TestCase;

class ZonePollueeManagerTest extends TestCase
{
    public function testValidZone()
    {
        $zone = new ZonePolluee();
        $zone->setNomZone('Plage Nord');
        $zone->setNiveauPollution(5);

        $manager = new ZonePollueeManager();
        $this->assertTrue($manager->validate($zone));
    }

    public function testZoneWithInvalidNiveauLow()
    {
        $this->expectException(\InvalidArgumentException::class);

        $zone = new ZonePolluee();
        $zone->setNomZone('Plage Nord');
        $zone->setNiveauPollution(0);

        $manager = new ZonePollueeManager();
        $manager->validate($zone);
    }

    public function testZoneWithInvalidNiveauHigh()
    {
        $this->expectException(\InvalidArgumentException::class);

        $zone = new ZonePolluee();
        $zone->setNomZone('Plage Nord');
        $zone->setNiveauPollution(11);

        $manager = new ZonePollueeManager();
        $manager->validate($zone);
    }

    public function testZoneWithoutName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $zone = new ZonePolluee();
        $zone->setNiveauPollution(5);

        $manager = new ZonePollueeManager();
        $manager->validate($zone);
    }
}