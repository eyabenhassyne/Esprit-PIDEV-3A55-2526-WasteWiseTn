<?php

namespace App\Controller;

use App\Entity\DeclarationDechet;
use App\Entity\User;
use App\Repository\DeclarationDechetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/declarations')]
#[IsGranted('ROLE_ADMIN')]
class AdminDeclarationController extends AbstractController
{
    #[Route('', name: 'admin_declarations', methods: ['GET'])]
    public function index(Request $request, DeclarationDechetRepository $declarationRepository): Response
    {
        $filters = $this->extractFilters($request);
        $page = max(1, $request->query->getInt('page', 1));
        $perPage = 10;

        $result = $declarationRepository->findAdminDeclarations($filters, $page, $perPage);
        $stats = $declarationRepository->getAdminStatCards();
        $intelligence = $declarationRepository->getIntelligenceInsights();
        $filterOptions = $declarationRepository->getAdminFilterOptions();
        $riskReference = $declarationRepository->getRiskReference();
        $heatmapPoints = $declarationRepository->getHeatmapPoints($filters);
        $activity = $declarationRepository->getRealtimeActivity();
        $chart = $declarationRepository->getDeclarationsByTypeStats($filters);

        $payload = [
            'declarations' => $result['items'],
            'riskById' => $this->buildRiskMap($result['items'], $riskReference),
            'stats' => $stats,
            'intelligence' => $intelligence,
            'filters' => $filters,
            'filterOptions' => $filterOptions,
            'riskReference' => $riskReference,
            'heatmapPoints' => $heatmapPoints,
            'activity' => $activity,
            'chart' => $chart,
            'pagination' => [
                'page' => $result['page'],
                'pages' => $result['pages'],
                'total' => $result['total'],
                'perPage' => $perPage,
            ],
            'refreshAt' => new \DateTimeImmutable(),
        ];

        if ($request->isXmlHttpRequest() || $request->query->getBoolean('ajax')) {
            return $this->json([
                'tableHtml' => $this->renderView('admin/declarations/_table_rows.html.twig', [
                    'declarations' => $payload['declarations'],
                    'riskById' => $payload['riskById'],
                ]),
                'paginationHtml' => $this->renderView('admin/declarations/_pagination.html.twig', [
                    'pagination' => $payload['pagination'],
                ]),
                'activityHtml' => $this->renderView('admin/declarations/_activity_feed.html.twig', [
                    'activity' => $payload['activity'],
                ]),
                'pagination' => $payload['pagination'],
                'stats' => $stats,
                'intelligence' => $intelligence,
                'heatmapPoints' => $heatmapPoints,
                'chart' => $chart,
                'refreshAt' => $payload['refreshAt']->format(DATE_ATOM),
            ]);
        }

        return $this->render('admin/declarations/index.html.twig', $payload);
    }

    #[Route('/stats', name: 'admin_declarations_stats', methods: ['GET'])]
    public function stats(Request $request, DeclarationDechetRepository $declarationRepository): JsonResponse
    {
        $chart = $declarationRepository->getDeclarationsByTypeStats($this->extractFilters($request));

        return $this->json([
            'labels' => $chart['labels'],
            'values' => $chart['values'],
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/heatmap', name: 'admin_declarations_heatmap', methods: ['GET'])]
    public function heatmap(Request $request, DeclarationDechetRepository $declarationRepository): JsonResponse
    {
        return $this->json([
            'points' => $declarationRepository->getHeatmapPoints($this->extractFilters($request)),
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/activity', name: 'admin_declarations_activity', methods: ['GET'])]
    public function activity(DeclarationDechetRepository $declarationRepository): JsonResponse
    {
        return $this->json([
            'html' => $this->renderView('admin/declarations/_activity_feed.html.twig', [
                'activity' => $declarationRepository->getRealtimeActivity(),
            ]),
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/export/csv', name: 'admin_declarations_export_csv', methods: ['GET'])]
    public function exportCsv(Request $request, DeclarationDechetRepository $declarationRepository): Response
    {
        $declarations = $declarationRepository->findAdminDeclarationsForExport($this->extractFilters($request));

        $stream = fopen('php://temp', 'w+');
        if (false === $stream) {
            return new Response('Impossible de generer le CSV.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        fputcsv($stream, ['ID', 'Date', 'Statut', 'Type', 'Quantite', 'Unite', 'Citoyen', 'Email citoyen', 'Valorisateur', 'EcoPoints'], ';');
        foreach ($declarations as $declaration) {
            $citoyenName = trim((string) (($declaration->getCitoyen()?->getPrenom() ?? '').' '.($declaration->getCitoyen()?->getNom() ?? '')));
            $valorisateurName = trim((string) (($declaration->getValorisateurConfirmateur()?->getPrenom() ?? '').' '.($declaration->getValorisateurConfirmateur()?->getNom() ?? '')));

            fputcsv($stream, [
                $declaration->getId(),
                $declaration->getCreatedAt()?->format('Y-m-d H:i:s'),
                $declaration->getStatut(),
                $declaration->getTypeDechet()?->getLibelle(),
                $declaration->getQuantite(),
                $declaration->getUnite(),
                '' !== $citoyenName ? $citoyenName : 'Anonyme',
                $declaration->getCitoyen()?->getEmail(),
                '' !== $valorisateurName ? $valorisateurName : 'Non confirme',
                $declaration->getPointsAttribues(),
            ], ';');
        }

        rewind($stream);
        $content = (string) stream_get_contents($stream);
        fclose($stream);

        return new Response($content, Response::HTTP_OK, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="declarations-admin.csv"',
        ]);
    }

    #[Route('/export/pdf', name: 'admin_declarations_export_pdf', methods: ['GET'])]
    public function exportPdf(Request $request, DeclarationDechetRepository $declarationRepository): Response
    {
        $declarations = $declarationRepository->findAdminDeclarationsForExport($this->extractFilters($request), 1200);
        $stats = $declarationRepository->getAdminStatCards();

        $html = $this->renderView('admin/declarations/export_pdf.html.twig', [
            'declarations' => $declarations,
            'stats' => $stats,
            'generatedAt' => new \DateTimeImmutable(),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="declarations-admin.pdf"',
        ]);
    }

    #[Route('/{id}/details', name: 'admin_declarations_show_details', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function showDetails(
        int $id,
        DeclarationDechetRepository $declarationRepository,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {
        $declaration = $declarationRepository->findAdminDetailsById($id);
        if (!$declaration instanceof DeclarationDechet) {
            return $this->json([
                'success' => false,
                'message' => 'Declaration introuvable.',
            ], Response::HTTP_NOT_FOUND);
        }

        $history = $declaration->getStatutHistorique();
        if ([] === $history) {
            $history = [
                [
                    'statut' => $declaration->getStatut(),
                    'acteur' => 'Systeme',
                    'note' => 'Historique initialise automatiquement.',
                    'date' => $declaration->getCreatedAt()?->format(DATE_ATOM),
                ],
            ];
        }

        $risk = $this->buildRiskPayload($declaration, $declarationRepository->getRiskReference());

        return $this->json([
            'success' => true,
            'declaration' => [
                'id' => $declaration->getId(),
                'description' => $declaration->getDescription(),
                'photoUrl' => $declaration->getPhoto() ? '/uploads/dechets/'.$declaration->getPhoto() : null,
                'latitude' => $declaration->getLatitude(),
                'longitude' => $declaration->getLongitude(),
                'quantite' => $declaration->getQuantite(),
                'unite' => $declaration->getUnite(),
                'statut' => $declaration->getStatut(),
                'typeDechet' => $declaration->getTypeDechet()?->getLibelle(),
                'ecoPoints' => $declaration->getPointsAttribues(),
                'scoreIa' => $declaration->getScoreIa(),
                'createdAt' => $declaration->getCreatedAt()?->format('d/m/Y'),
                'dateConfirmation' => $declaration->getDateConfirmation()?->format('d/m/Y H:i'),
                'history' => $history,
                'risk' => $risk,
                'citoyen' => $this->buildUserProfilePayload($declaration->getCitoyen()),
                'valorisateur' => $this->buildUserProfilePayload($declaration->getValorisateurConfirmateur()),
                'deleteToken' => $csrfTokenManager->getToken('admin_delete_declaration_'.$declaration->getId())->getValue(),
            ],
        ]);
    }

    #[Route('/{id}', name: 'admin_declarations_delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function delete(
        int $id,
        Request $request,
        DeclarationDechetRepository $declarationRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $declaration = $declarationRepository->find($id);
        if (!$declaration instanceof DeclarationDechet || null !== $declaration->getDeletedAt()) {
            return $this->json([
                'success' => false,
                'message' => 'Declaration introuvable ou deja supprimee.',
            ], Response::HTTP_NOT_FOUND);
        }

        $token = (string) $request->headers->get('X-CSRF-TOKEN', '');
        if ('' === $token) {
            $payload = json_decode($request->getContent(), true);
            if (\is_array($payload)) {
                $token = (string) ($payload['_token'] ?? '');
            }
        }

        if (!$this->isCsrfTokenValid('admin_delete_declaration_'.$declaration->getId(), $token)) {
            return $this->json([
                'success' => false,
                'message' => 'Token CSRF invalide.',
            ], Response::HTTP_FORBIDDEN);
        }

        $declaration->setDeletedAt(new \DateTimeImmutable());
        $declaration->addHistoriqueStatut('SUPPRIMEE', $this->resolveActorName(), 'Suppression par administrateur');

        $entityManager->persist($declaration);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'message' => 'Declaration supprimee.',
            'stats' => $declarationRepository->getAdminStatCards(),
            'activityHtml' => $this->renderView('admin/declarations/_activity_feed.html.twig', [
                'activity' => $declarationRepository->getRealtimeActivity(),
            ]),
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function extractFilters(Request $request): array
    {
        return [
            'status' => (string) $request->query->get('status', ''),
            'search' => (string) $request->query->get('search', ''),
            'sort' => strtolower((string) $request->query->get('sort', 'desc')),
            'type' => (int) $request->query->get('type', 0),
            'valorisateur' => (int) $request->query->get('valorisateur', 0),
            'quantityMin' => (string) $request->query->get('quantityMin', ''),
            'quantityMax' => (string) $request->query->get('quantityMax', ''),
        ];
    }

    /**
     * @param array<int, DeclarationDechet> $declarations
     * @param array{avgQty: float, maxQty: float} $riskReference
     * @return array<int, array{score: int, label: string, level: string}>
     */
    private function buildRiskMap(array $declarations, array $riskReference): array
    {
        $riskById = [];
        foreach ($declarations as $declaration) {
            if (!$declaration instanceof DeclarationDechet || $declaration->getId() === null) {
                continue;
            }

            $riskById[$declaration->getId()] = $this->buildRiskPayload($declaration, $riskReference);
        }

        return $riskById;
    }

    /**
     * @param array{avgQty: float, maxQty: float} $riskReference
     * @return array{score: int, label: string, level: string}
     */
    private function buildRiskPayload(DeclarationDechet $declaration, array $riskReference): array
    {
        $avgQty = max(0.1, (float) ($riskReference['avgQty'] ?? 0));
        $maxQty = max($avgQty, (float) ($riskReference['maxQty'] ?? 0));
        $quantity = (float) ($declaration->getQuantite() ?? 0);
        $scoreIa = $declaration->getScoreIa();

        $quantityBase = max($avgQty * 2, $maxQty * 0.65);
        $quantityScore = min(75, ($quantityBase > 0 ? ($quantity / $quantityBase) * 75 : 0));
        $iaScore = $scoreIa !== null ? min(25, max(0, $scoreIa * 25)) : 8;
        $score = (int) max(0, min(100, round($quantityScore + $iaScore)));

        if ($score >= 75) {
            return ['score' => $score, 'label' => 'Eleve', 'level' => 'high'];
        }
        if ($score >= 45) {
            return ['score' => $score, 'label' => 'Moyen', 'level' => 'medium'];
        }

        return ['score' => $score, 'label' => 'Faible', 'level' => 'low'];
    }

    private function resolveActorName(): string
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            $name = trim((string) ($user->getPrenom().' '.$user->getNom()));
            if ('' !== $name) {
                return $name;
            }

            return (string) $user->getEmail();
        }

        return 'Admin';
    }

    /**
     * @return array<string, mixed>|null
     */
    private function buildUserProfilePayload(?User $user): ?array
    {
        if (!$user instanceof User) {
            return null;
        }

        return [
            'id' => $user->getId(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'fullName' => trim((string) ($user->getPrenom().' '.$user->getNom())),
            'email' => $user->getEmail(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'photoProfil' => $user->getPhotoProfil() ? '/uploads/profiles/'.$user->getPhotoProfil() : null,
        ];
    }
}
