<?php

namespace App\Tests\Entity;

use App\Entity\AppelOffre;
use App\Entity\ReponseOffre;
use App\Entity\Valorisateur;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AppelOffreTest extends TestCase
{
    public function testTitreIsRequired(): void
    {
        $appelOffre = $this->createValidAppelOffre();
        $appelOffre->setTitre('');

        $violations = $this->createValidator()->validate($appelOffre);

        self::assertTrue($this->hasViolationForProperty($violations, 'titre'));
    }

    public function testQuantiteDemandeeMustBePositive(): void
    {
        $appelOffre = $this->createValidAppelOffre();
        $appelOffre->setQuantiteDemandee(0);

        $violations = $this->createValidator()->validate($appelOffre);

        self::assertTrue($this->hasViolationForProperty($violations, 'quantiteDemandee'));
    }

    public function testDateLimiteMustBeInFuture(): void
    {
        $appelOffre = $this->createValidAppelOffre();
        $appelOffre->defineDateLimite(new \DateTimeImmutable('-1 day'));

        $violations = $this->createValidator()->validate($appelOffre);

        self::assertTrue($this->hasViolationForProperty($violations, 'dateLimite'));
    }

    public function testAddReponseOffreSetsOwningSideAndPreventsDuplicates(): void
    {
        $appelOffre = new AppelOffre();
        $reponse = new ReponseOffre();

        $appelOffre->addReponseOffre($reponse);
        $appelOffre->addReponseOffre($reponse);

        self::assertCount(1, $appelOffre->getReponseOffres());
        self::assertSame($appelOffre, $reponse->getAppelOffre());
    }

    public function testRemoveReponseOffreClearsOwningSide(): void
    {
        $appelOffre = new AppelOffre();
        $reponse = new ReponseOffre();

        $appelOffre->addReponseOffre($reponse);
        $appelOffre->removeReponseOffre($reponse);

        self::assertCount(0, $appelOffre->getReponseOffres());
        self::assertNull($reponse->getAppelOffre());
    }

    private function createValidator(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();
    }

    private function createValidAppelOffre(): AppelOffre
    {
        $appelOffre = new AppelOffre();
        $appelOffre->setTitre('Collecte plastique');
        $appelOffre->setDescription('Collecte de dechets plastiques pour traitement.');
        $appelOffre->setQuantiteDemandee(120.5);
        $appelOffre->defineDateLimite(new \DateTimeImmutable('+5 days'));
        $appelOffre->setValorisateur(new Valorisateur());

        return $appelOffre;
    }

    /**
     * @param iterable<ConstraintViolationInterface> $violations
     */
    private function hasViolationForProperty(iterable $violations, string $propertyPath): bool
    {
        foreach ($violations as $violation) {
            if ($violation->getPropertyPath() === $propertyPath) {
                return true;
            }
        }

        return false;
    }
}
