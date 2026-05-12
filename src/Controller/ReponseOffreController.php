<?php

namespace App\Controller;

use App\Entity\Citoyen;
use App\Entity\ReponseOffre;
use App\Form\ReponseOffreType;
use App\Repository\CitoyenRepository;
use App\Repository\ReponseOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reponse/offre')]
final class ReponseOffreController extends AbstractController
{
    #[Route(name: 'app_reponse_offre_index', methods: ['GET'])]
    public function index(Request $request, ReponseOffreRepository $reponseOffreRepository): Response
    {
        return $this->renderIndex($request, $reponseOffreRepository, false);
    }

    #[Route('/moderation', name: 'app_reponse_offre_moderation', methods: ['GET'])]
    public function moderation(Request $request, ReponseOffreRepository $reponseOffreRepository): Response
    {
        return $this->renderIndex($request, $reponseOffreRepository, true);
    }

    private function renderIndex(
        Request $request,
        ReponseOffreRepository $reponseOffreRepository,
        bool $moderationMode
    ): Response
    {
        $query = $request->query->getString('q');
        $statut = trim($request->query->getString('statut'));
        $quantiteMinRaw = trim($request->query->getString('quantite_min'));
        $sort = $request->query->getString('sort', 'dateSoumis');
        $direction = $request->query->getString('direction', 'DESC');
        $quantiteMinFilter = is_numeric($quantiteMinRaw) ? (float) $quantiteMinRaw : null;
        $isScoreSort = $moderationMode && $sort === 'score';

        $reponses = $reponseOffreRepository->searchAndSort(
            $query,
            $isScoreSort ? 'dateSoumis' : $sort,
            $direction,
            [
                'statut' => $statut !== '' ? $statut : null,
                'quantite_min' => $quantiteMinFilter,
            ]
        );

        $scores = [];
        foreach ($reponses as $reponse) {
            $scores[$reponse->getId() ?? 0] = $this->computeDecisionScore($reponse);
        }

        if ($isScoreSort) {
            usort(
                $reponses,
                function (ReponseOffre $left, ReponseOffre $right) use ($direction, $scores): int {
                    $leftScore = $scores[$left->getId() ?? 0] ?? 0;
                    $rightScore = $scores[$right->getId() ?? 0] ?? 0;
                    $cmp = $leftScore <=> $rightScore;

                    return strtoupper($direction) === 'ASC' ? $cmp : -$cmp;
                }
            );
        }

        return $this->render('reponse_offre/index.html.twig', [
            'reponse_offres' => $reponses,
            'scores' => $scores,
            'q' => $query,
            'statut' => $statut,
            'quantite_min' => $quantiteMinRaw,
            'sort' => $sort,
            'direction' => strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC',
            'moderation_mode' => $moderationMode,
        ]);
    }

    #[Route('/new', name: 'app_reponse_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CitoyenRepository $citoyenRepository): Response
    {
        $reponseOffre = new ReponseOffre();
        $reponseOffre->setStatut(ReponseOffre::STATUT_EN_ATTENTE);

        // Remplir automatiquement le citoyen depuis l'utilisateur connecté
        $user = $this->getUser();
        if ($user !== null) {
            $citoyen = $citoyenRepository->findOneByEmail($user->getUserIdentifier());
            if ($citoyen === null) {
                // Créer un citoyen automatiquement si inexistant
                $citoyen = new Citoyen();
                $citoyen->setNom($user->getNom() ?? 'Inconnu');
                $citoyen->setPrenom($user->getPrenom() ?? 'Inconnu');
                $citoyen->setEmail($user->getUserIdentifier());
                $entityManager->persist($citoyen);
                $entityManager->flush();
            }
            $reponseOffre->setCitoyen($citoyen);
        }

        $form = $this->createForm(ReponseOffreType::class, $reponseOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isExpiredAppelOffre($reponseOffre)) {
                $form->get('appelOffre')->addError(new FormError('Cet appel d\'offre est expire.'));
            } else {
                $entityManager->persist($reponseOffre);
                $entityManager->flush();
                $this->addFlash('success', sprintf(
                    'Reponse enregistree dans pidev avec succes (ID %d).',
                    $reponseOffre->getId()
                ));

                return $this->redirectToRoute('app_reponse_offre_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'La reponse n\'a pas ete enregistree: verifiez les champs obligatoires.');
        }

        return $this->render('reponse_offre/new.html.twig', [
            'reponse_offre' => $reponseOffre,
            'form' => $form,
        ]);
    }

    #[Route('/stats', name: 'app_reponse_offre_stats', methods: ['GET'])]
    public function stats(Request $request, ReponseOffreRepository $reponseOffreRepository): Response
    {
        $today = new \DateTimeImmutable('today');
        $toDate = $this->parseDateFromQuery($request->query->getString('to'), $today);
        $fromDefault = $toDate->modify('-29 days');
        $fromDate = $this->parseDateFromQuery($request->query->getString('from'), $fromDefault);

        if ($fromDate > $toDate) {
            [$fromDate, $toDate] = [$toDate, $fromDate];
        }

        $start = $fromDate->setTime(0, 0, 0);
        $end = $toDate->setTime(23, 59, 59);

        $statusDistribution = $reponseOffreRepository->getStatusDistributionBetween($start, $end);
        $dailyCountsRaw = $reponseOffreRepository->getDailyResponseCountsBetween($start, $end);
        $dailyQtyRaw = $reponseOffreRepository->getDailyQuantitySumsBetween($start, $end);
        $topOffers = $reponseOffreRepository->getTopOffersByResponsesBetween($start, $end, 6);

        $dateAxis = $this->buildDateAxis($start, $end);
        $dailyCounts = array_map(
            static fn (string $key): int => (int) ($dailyCountsRaw[$key] ?? 0),
            $dateAxis
        );
        $dailyQuantities = array_map(
            static fn (string $key): float => (float) ($dailyQtyRaw[$key] ?? 0.0),
            $dateAxis
        );

        $totalResponses = array_sum($dailyCounts);
        $totalQty = array_sum($dailyQuantities);
        $acceptanceRate = $totalResponses > 0
            ? round(($statusDistribution['valide'] / $totalResponses) * 100, 1)
            : 0.0;
        $avgQty = $totalResponses > 0
            ? round($totalQty / $totalResponses, 2)
            : 0.0;

        return $this->render('reponse_offre/stats.html.twig', [
            'filters' => [
                'from' => $fromDate->format('Y-m-d'),
                'to' => $toDate->format('Y-m-d'),
            ],
            'summary' => [
                'total_responses' => $totalResponses,
                'total_quantite' => round($totalQty, 2),
                'acceptance_rate' => $acceptanceRate,
                'avg_quantite' => $avgQty,
            ],
            'status_distribution' => $statusDistribution,
            'chart_payload' => [
                'labels' => array_map(
                    static fn (string $date): string => (new \DateTimeImmutable($date))->format('d/m'),
                    $dateAxis
                ),
                'responses_series' => $dailyCounts,
                'quantity_series' => $dailyQuantities,
                'status_labels' => ['Validees', 'En attente', 'Refusees', 'Autres'],
                'status_values' => [
                    $statusDistribution['valide'],
                    $statusDistribution['en_attente'],
                    $statusDistribution['refuse'],
                    $statusDistribution['autre'],
                ],
                'top_offer_labels' => array_map(static fn (array $item): string => $item['titre'], $topOffers),
                'top_offer_values' => array_map(static fn (array $item): int => $item['total'], $topOffers),
            ],
            'top_offers' => $topOffers,
        ]);
    }

    #[Route('/{id}', name: 'app_reponse_offre_show', methods: ['GET'])]
    public function show(Request $request, ReponseOffre $reponseOffre): Response
    {
        $from = $request->query->getString('from');

        return $this->render('reponse_offre/show.html.twig', [
            'reponse_offre' => $reponseOffre,
            'from_moderation' => $from === 'moderation',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reponse_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReponseOffre $reponseOffre, EntityManagerInterface $entityManager): Response
    {
        $fromModeration = $request->query->getString('from') === 'moderation';

        if (!$reponseOffre->isEnAttente()) {
            $this->addFlash('error', 'Modification impossible: cette reponse est deja traitee.');

            return $this->redirectToRoute('app_reponse_offre_show', [
                'id' => $reponseOffre->getId(),
                'from' => $fromModeration ? 'moderation' : 'front',
            ]);
        }

        $form = $this->createForm(ReponseOffreType::class, $reponseOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isExpiredAppelOffre($reponseOffre)) {
                $form->get('appelOffre')->addError(new FormError('Cet appel d\'offre est expire.'));
            } else {
                $entityManager->flush();

                return $this->redirectToRoute(
                    $fromModeration ? 'app_reponse_offre_moderation' : 'app_reponse_offre_index',
                    [],
                    Response::HTTP_SEE_OTHER
                );
            }
        }

        return $this->render('reponse_offre/edit.html.twig', [
            'reponse_offre' => $reponseOffre,
            'form' => $form,
            'from_moderation' => $fromModeration,
        ]);
    }

    #[Route('/{id}/status/{target}', name: 'app_reponse_offre_change_status', methods: ['POST'])]
    public function changeStatus(
        Request $request,
        ReponseOffre $reponseOffre,
        string $target,
        EntityManagerInterface $entityManager
    ): Response {
        // Check if user is admin (required for moderation)
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Acces refuse.');
            return $this->redirectToRoute('app_reponse_offre_index');
        }
        
        $csrf = $request->request->getString('_token');
        if (!$this->isCsrfTokenValid('status'.$reponseOffre->getId(), $csrf)) {
            $this->addFlash('error', 'Action refusee (token CSRF invalide).');
            return $this->redirectToRoute('app_reponse_offre_index');
        }

        if (!$reponseOffre->canTransitionTo($target)) {
            $this->addFlash('error', 'Transition de statut non autorisee.');
            return $this->redirectToRoute('app_reponse_offre_show', ['id' => $reponseOffre->getId()]);
        }

        $reponseOffre->setStatut($target);
        $entityManager->flush();

        // Show success message
        if ($reponseOffre->getStatut() === ReponseOffre::STATUT_VALIDE) {
            $this->addFlash('success', 'Reponse validee avec succes.');
        } else {
            $this->addFlash('success', 'Reponse refusee avec succes.');
        }

        return $this->redirectToRoute('app_reponse_offre_moderation');
    }

    #[Route('/{id}', name: 'app_reponse_offre_delete', methods: ['POST'])]
    public function delete(Request $request, ReponseOffre $reponseOffre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseOffre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reponseOffre);
            $entityManager->flush();
        }

        $redirect = $request->request->getString('redirect_to');

        return $this->redirectToRoute(
            $redirect === 'moderation' ? 'app_reponse_offre_moderation' : 'app_reponse_offre_index',
            [],
            Response::HTTP_SEE_OTHER
        );
    }

    private function isExpiredAppelOffre(ReponseOffre $reponseOffre): bool
    {
        return $reponseOffre->getAppelOffre()?->isExpired() ?? true;
    }

    private function computeDecisionScore(ReponseOffre $reponse): int
    {
        $offre = $reponse->getAppelOffre();
        $demandee = $offre?->getQuantiteDemandee() ?? 0.0;
        $proposee = $reponse->getQuantiteProposee();

        $quantiteScore = 0;
        if ($demandee > 0) {
            $ratio = max(0.0, min(1.0, $proposee / $demandee));
            $quantiteScore = (int) round($ratio * 60);
        }

        $soumis = $reponse->getDateSoumis();
        $days = max(0, (int) $soumis->diff(new \DateTimeImmutable())->format('%a'));
        $freshnessScore = max(0, 20 - min(20, $days));

        $status = $reponse->getStatut();
        $statusScore = $reponse->isEnAttente() ? 20 : (str_starts_with($status, 'val') ? 10 : 5);

        return max(0, min(100, $quantiteScore + $freshnessScore + $statusScore));
    }

    private function parseDateFromQuery(string $value, \DateTimeImmutable $fallback): \DateTimeImmutable
    {
        if ($value === '') {
            return $fallback;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $value);

        return $date ?: $fallback;
    }

    /**
     * @return array<int,string>
     */
    private function buildDateAxis(\DateTimeImmutable $start, \DateTimeImmutable $end): array
    {
        $axis = [];
        $cursor = $start;

        while ($cursor <= $end) {
            $axis[] = $cursor->format('Y-m-d');
            $cursor = $cursor->modify('+1 day');
        }

        return $axis;
    }
}
