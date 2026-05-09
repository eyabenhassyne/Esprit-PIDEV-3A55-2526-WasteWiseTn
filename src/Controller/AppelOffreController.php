<?php

namespace App\Controller;

use App\Entity\AppelOffre;
use App\Form\AppelOffreType;
use App\Repository\AppelOffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/appel/offre')]
final class AppelOffreController extends AbstractController
{
    #[Route(name: 'app_appel_offre_index', methods: ['GET'])]
    public function index(Request $request, AppelOffreRepository $appelOffreRepository): Response
    {
        $query = $request->query->getString('q');
        $quantiteMinRaw = trim($request->query->getString('quantite_min'));
        $etat = trim($request->query->getString('etat'));
        $sort = $request->query->getString('sort', 'dateLimite');
        $direction = $request->query->getString('direction', 'DESC');
        $quantiteMinFilter = is_numeric($quantiteMinRaw) ? (float) $quantiteMinRaw : null;
        $etatFilter = in_array($etat, ['active', 'expiree'], true) ? $etat : '';

        return $this->render('appel_offre/index.html.twig', [
            'appel_offres' => $appelOffreRepository->searchAndSort(
                $query,
                $sort,
                $direction,
                [
                    'quantite_min' => $quantiteMinFilter,
                    'etat' => $etatFilter !== '' ? $etatFilter : null,
                ]
            ),
            'q' => $query,
            'quantite_min' => $quantiteMinRaw,
            'etat' => $etatFilter,
            'sort' => $sort,
            'direction' => strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC',
        ]);
    }

    #[Route('/new', name: 'app_appel_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appelOffre = new AppelOffre();
        $form = $this->createForm(AppelOffreType::class, $appelOffre);
        $form->get('dateLimiteInput')->setData($appelOffre->getDateLimite());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $dateLimite = $form->get('dateLimiteInput')->getData();
            if ($dateLimite instanceof \DateTimeInterface) {
                $appelOffre->defineDateLimite($dateLimite);
            } else {
                $form->get('dateLimiteInput')->addError(new FormError('La date limite est obligatoire.'));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appelOffre);
            $entityManager->flush();

            return $this->redirectToRoute('app_appel_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appel_offre/new.html.twig', [
            'appel_offre' => $appelOffre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appel_offre_show', methods: ['GET'])]
    public function show(AppelOffre $appelOffre): Response
    {
        return $this->render('appel_offre/show.html.twig', [
            'appel_offre' => $appelOffre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appel_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AppelOffre $appelOffre, EntityManagerInterface $entityManager): Response
    {
        if ($appelOffre->isExpired()) {
            $this->addFlash('error', 'Modification impossible: cet appel d\'offre est expire.');

            return $this->redirectToRoute('app_appel_offre_show', ['id' => $appelOffre->getId()]);
        }

        $form = $this->createForm(AppelOffreType::class, $appelOffre);
        $form->get('dateLimiteInput')->setData($appelOffre->getDateLimite());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $dateLimite = $form->get('dateLimiteInput')->getData();
            if ($dateLimite instanceof \DateTimeInterface) {
                $appelOffre->defineDateLimite($dateLimite);
            } else {
                $form->get('dateLimiteInput')->addError(new FormError('La date limite est obligatoire.'));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_appel_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appel_offre/edit.html.twig', [
            'appel_offre' => $appelOffre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appel_offre_delete', methods: ['POST'])]
    public function delete(Request $request, AppelOffre $appelOffre, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$appelOffre->getId(), $request->request->getString('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');

            return $this->redirectToRoute('app_appel_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        try {
            $entityManager->remove($appelOffre);
            $entityManager->flush();
            $this->addFlash('success', 'Appel d\'offre supprime avec succes.');
        } catch (ForeignKeyConstraintViolationException) {
            $this->addFlash('error', 'Suppression impossible: des reponses liees existent encore.');
        }

        return $this->redirectToRoute('app_appel_offre_index', [], Response::HTTP_SEE_OTHER);
    }
}
