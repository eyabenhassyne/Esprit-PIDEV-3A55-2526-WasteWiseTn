<?php

namespace App\Tests\Service;

use App\Repository\AppelOffreRepository;
use App\Repository\ReponseOffreRepository;
use App\Service\AdminAlertService;
use PHPUnit\Framework\TestCase;

final class AdminAlertServiceTest extends TestCase
{
    public function testBuildAlertCenterReturnsCriticalAlertsWithPriority(): void
    {
        $appelRepo = $this->createMock(AppelOffreRepository::class);
        $reponseRepo = $this->createMock(ReponseOffreRepository::class);

        $appelRepo->method('countExpired')->willReturn(3);
        $appelRepo->method('countUrgentActive')->willReturn(6);
        $appelRepo->method('countActiveWithoutResponses')->willReturn(2);

        $reponseRepo->method('countPendingOlderThan')->willReturn(9);
        $reponseRepo->method('countCreatedBetween')->willReturn(20);
        $reponseRepo->method('countRejectedBetween')->willReturn(12);

        $service = new AdminAlertService($appelRepo, $reponseRepo);
        $result = $service->buildAlertCenter(new \DateTimeImmutable('2026-02-25 10:00:00'));

        self::assertSame(5, $result['summary']['total']);
        self::assertGreaterThanOrEqual(1, $result['summary']['critical']);
        self::assertSame('critical', $result['alerts'][0]['level']);
    }

    public function testBuildAlertCenterReturnsInfoWhenNoRiskDetected(): void
    {
        $appelRepo = $this->createMock(AppelOffreRepository::class);
        $reponseRepo = $this->createMock(ReponseOffreRepository::class);

        $appelRepo->method('countExpired')->willReturn(0);
        $appelRepo->method('countUrgentActive')->willReturn(0);
        $appelRepo->method('countActiveWithoutResponses')->willReturn(0);

        $reponseRepo->method('countPendingOlderThan')->willReturn(0);
        $reponseRepo->method('countCreatedBetween')->willReturn(0);
        $reponseRepo->method('countRejectedBetween')->willReturn(0);

        $service = new AdminAlertService($appelRepo, $reponseRepo);
        $result = $service->buildAlertCenter(new \DateTimeImmutable('2026-02-25 10:00:00'));

        self::assertSame(1, $result['summary']['total']);
        self::assertSame(1, $result['summary']['info']);
        self::assertSame('Aucune alerte bloquante', $result['alerts'][0]['title']);
    }
}

