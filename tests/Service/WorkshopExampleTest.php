<?php

namespace App\Tests\Service;

use App\Entity\DeclarationDechet;
use PHPUnit\Framework\TestCase;

class WorkshopExampleTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testQuantiteInvalideLeveUneException(): void
    {
        $declaration = new DeclarationDechet();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La quantite doit etre strictement positive.');

        $declaration->setQuantite(0);
    }

    public function testDescriptionVideLeveUneException(): void
    {
        $declaration = new DeclarationDechet();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La description est obligatoire.');

        $declaration->setDescription('');
    }

    public function testMissingLocation(): void
    {
        $declaration = new DeclarationDechet();
        $declaration->setQuantite(2.5);
        $declaration->setDescription('Dechets menagers a collecter.');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La localisation GPS est obligatoire.');

        $declaration->validateLocation();
    }
}
