<?php

namespace App\Controller;

use App\Entity\BonAchat;
use App\Entity\User;
use App\Form\BonAchatType;
use App\Repository\BonAchatRepository;
use App\Repository\UserRepository;
use App\Service\PartenaireAnalyticsService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/partenaire')]
class PartenaireController extends AbstractController
{
    #[Route('', name: 'partenaire_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('partenaire_dashboard');
    }

    #[Route('/dashboard', name: 'partenaire_dashboard', methods: ['GET'])]
    public function dashboard(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService,
        BonAchatRepository $bonAchatRepository
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $payload = $analyticsService->buildDashboardPayload($partenaire);

        return $this->render('partenaire/dashboard.html.twig', [
            'partenaire' => $partenaire,
            'kpis' => $payload['kpis'],
            'badge' => $payload['badge'],
            'ranking' => $payload['ranking'],
            'expiringVouchers' => $payload['expiringVouchers'],
            'storePerformance' => $payload['storePerformance'],
            'monthlyDistributed' => $payload['monthlyDistributed'],
            'impactGlobal' => $payload['impactGlobal'],
            'voucherCards' => $bonAchatRepository->findByPartenaireOrdered($partenaire),
        ]);
    }

    #[Route('/api/dashboard-stats', name: 'partenaire_dashboard_stats', methods: ['GET'])]
    public function dashboardStats(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): JsonResponse {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $payload = $analyticsService->buildDashboardPayload($partenaire);

        return $this->json([
            'kpis' => $payload['kpis'],
            'badge' => $payload['badge'],
            'ranking' => $payload['ranking'],
            'monthlyDistributed' => $payload['monthlyDistributed'],
            'storePerformance' => $payload['storePerformance'],
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/bons', name: 'partenaire_bons', methods: ['GET'])]
    public function bons(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        BonAchatRepository $bonAchatRepository,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $analyticsService->buildDashboardPayload($partenaire);

        return $this->render('partenaire/bons.html.twig', [
            'partenaire' => $partenaire,
            'bons' => $bonAchatRepository->findByPartenaireOrdered($partenaire),
            'expiringSoon' => $bonAchatRepository->findExpiringSoon($partenaire),
        ]);
    }

    #[Route('/bons/nouveau', name: 'partenaire_bons_new', methods: ['GET', 'POST'])]
    public function createBon(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $bon = (new BonAchat())
            ->setPartenaire($partenaire)
            ->setDateDebut(new \DateTimeImmutable())
            ->setDateExpiration((new \DateTimeImmutable())->modify('+30 days'))
            ->addHistoriqueModification('CREATION', $this->resolveActorName($partenaire));

        $form = $this->createForm(BonAchatType::class, $bon, [
            'require_logo' => true,
            'require_promo_image' => true,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->persistVoucherAssets($form->get('logoFile')->getData(), $bon, true, $slugger);
                $this->persistVoucherAssets($form->get('imagePromotionnelleFile')->getData(), $bon, false, $slugger);
            } catch (\RuntimeException $exception) {
                $this->addFlash('error', $exception->getMessage());

                return $this->render('partenaire/bon_form.html.twig', [
                    'partenaire' => $partenaire,
                    'form' => $form->createView(),
                    'bon' => $bon,
                    'mode' => 'create',
                ]);
            }
            $bon->refreshStatut();
            $bon->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($bon);
            $entityManager->flush();

            $this->addFlash('success', 'Bon d achat cree avec succes.');

            return $this->redirectToRoute('partenaire_bons');
        }

        return $this->render('partenaire/bon_form.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
            'bon' => $bon,
            'mode' => 'create',
        ]);
    }

    #[Route('/bons/{id}/modifier', name: 'partenaire_bons_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function editBon(
        BonAchat $bon,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        if ($bon->getPartenaire()?->getId() !== $partenaire->getId()) {
            throw $this->createAccessDeniedException('Bon inaccessible.');
        }

        $before = [
            'nomMagasin' => $bon->getNomMagasin(),
            'valeurMonetaire' => $bon->getValeurMonetaire(),
            'pointsRequis' => $bon->getPointsRequis(),
            'dateDebut' => $bon->getDateDebut()?->format('Y-m-d'),
            'dateExpiration' => $bon->getDateExpiration()?->format('Y-m-d'),
            'nombreMaximumUtilisations' => $bon->getNombreMaximumUtilisations(),
            'zoneGeographique' => $bon->getZoneGeographique(),
        ];

        $form = $this->createForm(BonAchatType::class, $bon, [
            'require_logo' => false,
            'require_promo_image' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->persistVoucherAssets($form->get('logoFile')->getData(), $bon, true, $slugger);
                $this->persistVoucherAssets($form->get('imagePromotionnelleFile')->getData(), $bon, false, $slugger);
            } catch (\RuntimeException $exception) {
                $this->addFlash('error', $exception->getMessage());

                return $this->render('partenaire/bon_form.html.twig', [
                    'partenaire' => $partenaire,
                    'form' => $form->createView(),
                    'bon' => $bon,
                    'mode' => 'edit',
                ]);
            }
            $bon->refreshStatut();
            $bon->setUpdatedAt(new \DateTimeImmutable());

            $after = [
                'nomMagasin' => $bon->getNomMagasin(),
                'valeurMonetaire' => $bon->getValeurMonetaire(),
                'pointsRequis' => $bon->getPointsRequis(),
                'dateDebut' => $bon->getDateDebut()?->format('Y-m-d'),
                'dateExpiration' => $bon->getDateExpiration()?->format('Y-m-d'),
                'nombreMaximumUtilisations' => $bon->getNombreMaximumUtilisations(),
                'zoneGeographique' => $bon->getZoneGeographique(),
            ];

            $changes = [];
            foreach ($before as $field => $value) {
                if (($after[$field] ?? null) !== $value) {
                    $changes[$field] = ['old' => $value, 'new' => $after[$field] ?? null];
                }
            }

            $bon->addHistoriqueModification('MODIFICATION', $this->resolveActorName($partenaire), $changes);
            $entityManager->flush();

            $this->addFlash('success', 'Bon d achat mis a jour.');

            return $this->redirectToRoute('partenaire_bons');
        }

        return $this->render('partenaire/bon_form.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
            'bon' => $bon,
            'mode' => 'edit',
        ]);
    }

    #[Route('/bons/{id}/supprimer', name: 'partenaire_bons_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteBon(
        BonAchat $bon,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        if ($bon->getPartenaire()?->getId() !== $partenaire->getId()) {
            throw $this->createAccessDeniedException('Bon inaccessible.');
        }

        if (!$this->isCsrfTokenValid('partenaire_delete_bon_'.$bon->getId(), (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');

            return $this->redirectToRoute('partenaire_bons');
        }

        if ($bon->getNombreUtilisations() > 0) {
            $this->addFlash('error', 'Suppression refusee: bon deja utilise.');

            return $this->redirectToRoute('partenaire_bons');
        }

        $entityManager->remove($bon);
        $entityManager->flush();
        $this->addFlash('success', 'Bon d achat supprime.');

        return $this->redirectToRoute('partenaire_bons');
    }

    #[Route('/bons/{id}/stats', name: 'partenaire_bons_stats', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function bonStats(
        BonAchat $bon,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        if ($bon->getPartenaire()?->getId() !== $partenaire->getId()) {
            throw $this->createAccessDeniedException('Bon inaccessible.');
        }

        $usageRate = $bon->getNombreMaximumUtilisations() > 0
            ? round(($bon->getNombreUtilisations() / $bon->getNombreMaximumUtilisations()) * 100, 2)
            : 0.0;

        return $this->render('partenaire/bon_stats.html.twig', [
            'partenaire' => $partenaire,
            'bon' => $bon,
            'usageRate' => $usageRate,
            'distributedValue' => round($bon->getNombreUtilisations() * $bon->getValeurMonetaire(), 2),
            'estimatedContribution' => round(
                ($bon->getNombreUtilisations() * 0.28) + (($bon->getNombreUtilisations() * $bon->getValeurMonetaire()) * 0.015),
                2
            ),
        ]);
    }

    #[Route('/heatmap', name: 'partenaire_heatmap', methods: ['GET'])]
    public function heatmap(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $from = $this->parseDateFilter($request->query->get('from'));
        $to = $this->parseDateFilter($request->query->get('to'));
        $zones = $analyticsService->getHeatmapZones($from, $to);

        return $this->render('partenaire/heatmap.html.twig', [
            'partenaire' => $partenaire,
            'zones' => $zones,
            'from' => $from,
            'to' => $to,
        ]);
    }

    #[Route('/api/heatmap', name: 'partenaire_heatmap_data', methods: ['GET'])]
    public function heatmapData(Request $request, PartenaireAnalyticsService $analyticsService): JsonResponse
    {
        $from = $this->parseDateFilter($request->query->get('from'));
        $to = $this->parseDateFilter($request->query->get('to'));

        return $this->json([
            'zones' => $analyticsService->getHeatmapZones($from, $to),
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/impact-global', name: 'partenaire_impact_global', methods: ['GET'])]
    public function impactGlobal(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);

        return $this->render('partenaire/impact_global.html.twig', [
            'partenaire' => $partenaire,
            'impact' => $analyticsService->getGlobalImpactPayload(),
        ]);
    }

    #[Route('/api/impact-global', name: 'partenaire_impact_global_data', methods: ['GET'])]
    public function impactGlobalData(PartenaireAnalyticsService $analyticsService): JsonResponse
    {
        return $this->json([
            'impact' => $analyticsService->getGlobalImpactPayload(),
            'refreshAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
        ]);
    }

    #[Route('/declarations', name: 'partenaire_declarations', methods: ['GET'])]
    public function declarations(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);

        return $this->render('partenaire/declarations.html.twig', [
            'partenaire' => $partenaire,
            'declarations' => $analyticsService->getReadOnlyDeclarations(),
        ]);
    }

    #[Route('/valorisation', name: 'partenaire_valorisation', methods: ['GET'])]
    public function valorisation(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);

        return $this->render('partenaire/valorisation.html.twig', [
            'partenaire' => $partenaire,
            'declarations' => $analyticsService->getReadOnlyValorisation(),
        ]);
    }

    #[Route('/export-fiscal/pdf', name: 'partenaire_export_fiscal_pdf', methods: ['GET'])]
    public function exportFiscalPdf(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        PartenaireAnalyticsService $analyticsService
    ): Response {
        $partenaire = $this->resolveCurrentPartenaire($userRepository, $entityManager, $passwordHasher);
        $from = $this->parseDateFilter($request->query->get('from'));
        $to = $this->parseDateFilter($request->query->get('to'));
        $report = $analyticsService->buildFiscalReportPayload($partenaire, $from, $to);

        $html = $this->renderView('partenaire/export_fiscal_pdf.html.twig', [
            'partenaire' => $partenaire,
            'report' => $report,
            'generatedAt' => new \DateTimeImmutable(),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), Response::HTTP_OK, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="rapport-fiscal-partenaire.pdf"',
        ]);
    }

    #[Route('/collectes', name: 'partenaire_collectes', methods: ['GET'])]
    public function legacyCollectes(): Response
    {
        return $this->redirectToRoute('partenaire_declarations');
    }

    #[Route('/zones', name: 'partenaire_zones', methods: ['GET'])]
    public function legacyZones(): Response
    {
        return $this->redirectToRoute('partenaire_heatmap');
    }

    #[Route('/planning', name: 'partenaire_planning', methods: ['GET'])]
    public function legacyPlanning(): Response
    {
        return $this->redirectToRoute('partenaire_bons');
    }

    #[Route('/parametres', name: 'partenaire_parametres', methods: ['GET'])]
    public function legacyParametres(): Response
    {
        return $this->redirectToRoute('partenaire_dashboard');
    }

    private function parseDateFilter(mixed $value): ?\DateTimeImmutable
    {
        if (!is_string($value) || '' === trim($value)) {
            return null;
        }

        try {
            return new \DateTimeImmutable(trim($value));
        } catch (\Throwable) {
            return null;
        }
    }

    private function persistVoucherAssets(
        mixed $file,
        BonAchat $bon,
        bool $isLogo,
        SluggerInterface $slugger
    ): void {
        if (!$file instanceof UploadedFile) {
            return;
        }

        $safeName = (string) $slugger->slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->guessExtension() ?: 'bin';
        $filename = $safeName.'-'.uniqid('', true).'.'.$extension;
        $uploadDir = rtrim((string) $this->getParameter('partenaire_upload_directory'), DIRECTORY_SEPARATOR);
        $targetDir = $isLogo ? $uploadDir.DIRECTORY_SEPARATOR.'logos' : $uploadDir.DIRECTORY_SEPARATOR.'promos';

        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0775, true);
        }

        try {
            $file->move($targetDir, $filename);
        } catch (FileException $exception) {
            throw new \RuntimeException('Echec upload fichier partenaire: '.$exception->getMessage(), previous: $exception);
        }

        if ($isLogo) {
            $bon->setLogoMagasin($filename);
        } else {
            $bon->setImagePromotionnelle($filename);
        }
    }

    private function resolveCurrentPartenaire(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): User {
        $securityUser = $this->getUser();
        if ($securityUser instanceof User) {
            return $securityUser;
        }

        $partnerUser = $userRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_PARTENAIRE%')
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($partnerUser instanceof User) {
            return $partnerUser;
        }

        $demo = (new User())
            ->setEmail('partner.demo@wastewise.tn')
            ->setPrenom('Partner')
            ->setNom('Demo')
            ->setRoles(['ROLE_PARTENAIRE'])
            ->setOrganisationCentre('Partenaire Demo')
            ->setZoneCouverture('Tunis');
        $demo->setPassword($passwordHasher->hashPassword($demo, 'partner123456'));
        $entityManager->persist($demo);
        $entityManager->flush();

        return $demo;
    }

    private function resolveActorName(User $fallback): string
    {
        $securityUser = $this->getUser();
        if ($securityUser instanceof User) {
            $name = trim((string) ($securityUser->getPrenom().' '.$securityUser->getNom()));
            if ('' !== $name) {
                return $name;
            }

            return (string) $securityUser->getEmail();
        }

        return (string) ($fallback->getEmail() ?? 'Partenaire');
    }
}
