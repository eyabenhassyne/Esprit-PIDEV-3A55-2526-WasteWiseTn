<?php

namespace App\Service;

use App\Repository\AppelOffreRepository;
use App\Repository\ReponseOffreRepository;

final class AdminAlertService
{
    public function __construct(
        private readonly AppelOffreRepository $appelOffreRepository,
        private readonly ReponseOffreRepository $reponseOffreRepository
    ) {
    }

    /**
     * @return array{
     *     generated_at:string,
     *     alerts:array<int, array{
     *         level:string,
     *         title:string,
     *         message:string,
     *         metric:string,
     *         action_label:string,
     *         route:string,
     *         route_params:array<string, string>
     *     }>,
     *     summary:array{critical:int,warning:int,info:int,total:int}
     * }
     */
    public function buildAlertCenter(?\DateTimeImmutable $referenceDate = null): array
    {
        $now = $referenceDate ?? new \DateTimeImmutable();
        $alerts = [];

        $expiredCalls = $this->appelOffreRepository->countExpired();
        if ($expiredCalls > 0) {
            $alerts[] = [
                'level' => 'critical',
                'title' => 'Appels expirés à traiter',
                'message' => sprintf(
                    '%s %s ont dépassé la date limite.',
                    $this->formatNumber($expiredCalls),
                    $this->pluralize('appel', $expiredCalls)
                ),
                'metric' => sprintf('%s expiré%s', $this->formatNumber($expiredCalls), $expiredCalls > 1 ? 's' : ''),
                'action_label' => 'Voir les appels expirés',
                'route' => 'app_appel_offre_index',
                'route_params' => ['etat' => 'expiree'],
            ];
        }

        $urgentCalls = $this->appelOffreRepository->countUrgentActive($now, $now->modify('+72 hours'));
        if ($urgentCalls > 0) {
            $alerts[] = [
                'level' => $urgentCalls >= 5 ? 'critical' : 'warning',
                'title' => 'Échéances sous 72 heures',
                'message' => sprintf(
                    '%s %s arrivent à échéance dans les 72 prochaines heures.',
                    $this->formatNumber($urgentCalls),
                    $this->pluralize('appel', $urgentCalls)
                ),
                'metric' => sprintf('%s urgent%s', $this->formatNumber($urgentCalls), $urgentCalls > 1 ? 's' : ''),
                'action_label' => 'Prioriser les offres urgentes',
                'route' => 'app_appel_offre_index',
                'route_params' => ['etat' => 'active', 'sort' => 'dateLimite', 'direction' => 'ASC'],
            ];
        }

        $stalePending = $this->reponseOffreRepository->countPendingOlderThan($now->modify('-3 days'));
        if ($stalePending > 0) {
            $alerts[] = [
                'level' => $stalePending >= 8 ? 'critical' : 'warning',
                'title' => 'Modération en retard',
                'message' => sprintf(
                    '%s %s en attente depuis plus de 3 jours.',
                    $this->formatNumber($stalePending),
                    $this->pluralize('réponse', $stalePending)
                ),
                'metric' => sprintf('%s en attente', $this->formatNumber($stalePending)),
                'action_label' => 'Traiter la file de modération',
                'route' => 'app_reponse_offre_moderation',
                'route_params' => ['statut' => 'en attente'],
            ];
        }

        $activeNoResponse = $this->appelOffreRepository->countActiveWithoutResponses($now);
        if ($activeNoResponse > 0) {
            $alerts[] = [
                'level' => $activeNoResponse >= 5 ? 'warning' : 'info',
                'title' => 'Appels actifs sans réponse',
                'message' => sprintf(
                    '%s %s actif%s n’a encore reçu aucune réponse.',
                    $this->formatNumber($activeNoResponse),
                    $this->pluralize('appel', $activeNoResponse),
                    $activeNoResponse > 1 ? 's' : ''
                ),
                'metric' => sprintf('%s sans réponse', $this->formatNumber($activeNoResponse)),
                'action_label' => 'Analyser les appels non couverts',
                'route' => 'app_appel_offre_index',
                'route_params' => ['etat' => 'active'],
            ];
        }

        $start30Days = $now->modify('-30 days');
        $responses30 = $this->reponseOffreRepository->countCreatedBetween($start30Days, $now);
        $rejected30 = $this->reponseOffreRepository->countRejectedBetween($start30Days, $now);

        if ($responses30 > 0) {
            $rejectionRate = ($rejected30 / $responses30) * 100;
            if ($rejectionRate >= 40) {
                $alerts[] = [
                    'level' => $rejectionRate >= 55 ? 'critical' : 'warning',
                    'title' => 'Taux de refus élevé (30 jours)',
                    'message' => sprintf(
                        '%s%% de refus sur %s %s analysées.',
                        number_format($rejectionRate, 1, ',', ' '),
                        $this->formatNumber($responses30),
                        $this->pluralize('réponse', $responses30)
                    ),
                    'metric' => sprintf('%s%% de refus', number_format($rejectionRate, 1, ',', ' ')),
                    'action_label' => 'Examiner les réponses refusées',
                    'route' => 'app_reponse_offre_moderation',
                    'route_params' => ['statut' => 'refuse'],
                ];
            }
        }

        if ($alerts === []) {
            $alerts[] = [
                'level' => 'info',
                'title' => 'Aucune alerte bloquante',
                'message' => 'Aucun risque opérationnel majeur détecté pour le moment.',
                'metric' => 'Système stable',
                'action_label' => 'Ouvrir la modération',
                'route' => 'app_reponse_offre_moderation',
                'route_params' => [],
            ];
        }

        usort(
            $alerts,
            fn (array $a, array $b): int => $this->levelWeight($b['level']) <=> $this->levelWeight($a['level'])
        );

        $summary = [
            'critical' => count(array_filter($alerts, static fn (array $a): bool => $a['level'] === 'critical')),
            'warning' => count(array_filter($alerts, static fn (array $a): bool => $a['level'] === 'warning')),
            'info' => count(array_filter($alerts, static fn (array $a): bool => $a['level'] === 'info')),
        ];
        $summary['total'] = $summary['critical'] + $summary['warning'] + $summary['info'];

        return [
            'generated_at' => $now->format('Y-m-d H:i:s'),
            'alerts' => $alerts,
            'summary' => $summary,
        ];
    }

    private function levelWeight(string $level): int
    {
        return match ($level) {
            'critical' => 3,
            'warning' => 2,
            default => 1,
        };
    }

    private function pluralize(string $word, int $count): string
    {
        return $count > 1 ? $word.'s' : $word;
    }

    private function formatNumber(int $value): string
    {
        return number_format($value, 0, ',', ' ');
    }
}

