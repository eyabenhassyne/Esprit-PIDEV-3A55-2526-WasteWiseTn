<?php

namespace App\Controller;

use App\Entity\ZonePolluee;
use App\Form\ZonePollueeType;
use App\Repository\ZonePollueeRepository;
use App\Service\QRCodeService;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zone-polluee')]
class ZonePollueeController extends AbstractController
{
    // LISTE (READ ALL) with SEARCH, FILTERS and STATS
    #[Route('/', name: 'app_zone_polluee_index', methods: ['GET'])]
    public function index(Request $request, ZonePollueeRepository $repository): Response
    {
        $search = $request->query->get('search', '');
        $filter = $request->query->get('filter', '');
        $sort = $request->query->get('sort', 'date_desc');
        
        $zones = $repository->findByFilters($search, $filter, $sort);
        
        // Calculate stats
        $totalZones = count($zones);
        $hautRisque = 0;
        $nouvellesZones = 0;
        $now = new \DateTime();
        $sevenDaysAgo = (clone $now)->modify('-7 days');
        
        foreach ($zones as $zone) {
            if ($zone->getNiveauPollution() >= 7) {
                $hautRisque++;
            }
            
            if ($zone->getDateIdentification() > $sevenDaysAgo) {
                $nouvellesZones++;
            }
        }
        
        return $this->render('zone_polluee/index.html.twig', [
            'zones' => $zones,
            'total_zones' => $totalZones,
            'haut_risque' => $hautRisque,
            'nouvelles_zones' => $nouvellesZones,
            'search' => $search,
            'current_filter' => $filter,
            'current_sort' => $sort,
        ]);
    }

    // AJOUTER (CREATE) - AVEC EMAILS
    #[Route('/new', name: 'app_zone_polluee_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        MailService $mailService
    ): Response
    {
        $zone = new ZonePolluee();
        $zone->setDateIdentification(new \DateTime());
        
        $form = $this->createForm(ZonePollueeType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zone);
            $entityManager->flush();

            // Envoi d'email - VERSION SIMPLIFIÉE
            try {
                // Email normal
                $mailService->sendZoneAlert($zone);
                
                // Email critique si niveau >= 7
                if ($zone->getNiveauPollution() >= 7) {
                    $mailService->sendCriticalAlert($zone);
                }
                
                $this->addFlash('success', '✅ Zone ajoutée avec succès ! Un email a été envoyé.');
            } catch (\Exception $e) {
                $this->addFlash('warning', '⚠️ Zone ajoutée mais email non envoyé: ' . $e->getMessage());
            }

            return $this->redirectToRoute('app_zone_polluee_index');
        }

        return $this->render('zone_polluee/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // DÉTAILS (READ ONE)
    #[Route('/{id}', name: 'app_zone_polluee_show', methods: ['GET'])]
    public function show(ZonePolluee $zone): Response
    {
        return $this->render('zone_polluee/show.html.twig', [
            'zone' => $zone,
        ]);
    }

    // MODIFIER (UPDATE)
    #[Route('/{id}/edit', name: 'app_zone_polluee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ZonePolluee $zone, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ZonePollueeType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', '✅ Zone modifiée avec succès !');
            return $this->redirectToRoute('app_zone_polluee_index');
        }

        return $this->render('zone_polluee/edit.html.twig', [
            'form' => $form->createView(),
            'zone' => $zone,
        ]);
    }

    // SUPPRIMER (DELETE)
    #[Route('/{id}/delete', name: 'app_zone_polluee_delete', methods: ['POST'])]
    public function delete(Request $request, ZonePolluee $zone, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zone->getId(), $request->request->get('_token'))) {
            $entityManager->remove($zone);
            $entityManager->flush();

            $this->addFlash('success', '✅ Zone supprimée avec succès !');
        }

        return $this->redirectToRoute('app_zone_polluee_index');
    }

    // ========== QR CODE METHODS ==========
    #[Route('/{id}/qr', name: 'app_zone_polluee_qr', methods: ['GET'])]
    public function showQR(ZonePolluee $zone, QRCodeService $qrService): Response
    {
        $qrPng = $qrService->generateColoredZoneQR($zone, 300);
        
        return $this->render('zone_polluee/qr.html.twig', [
            'zone' => $zone,
            'qr_png' => $qrPng,
        ]);
    }

    #[Route('/{id}/qr/download/png', name: 'app_zone_polluee_qr_download_png', methods: ['GET'])]
    public function downloadQRPNG(ZonePolluee $zone, QRCodeService $qrService): Response
    {
        return $qrService->createDownloadResponse($zone, 500);
    }

    #[Route('/qr/batch', name: 'app_zone_polluee_qr_batch', methods: ['GET'])]
    public function batchQR(ZonePollueeRepository $repository, QRCodeService $qrService): Response
    {
        $zones = $repository->findAll();
        $qrCodes = [];
        
        foreach ($zones as $zone) {
            $qrCodes[$zone->getId()] = [
                'zone' => $zone,
                'qr' => $qrService->generateColoredZoneQR($zone, 200)
            ];
        }
        
        return $this->render('zone_polluee/qr_batch.html.twig', [
            'qrCodes' => $qrCodes
        ]);
    }
}