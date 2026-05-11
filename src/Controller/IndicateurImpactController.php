<?php

namespace App\Controller;

use App\Entity\IndicateurImpact;
use App\Form\IndicateurImpactType;
use App\Repository\IndicateurImpactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/indicateur-impact')]
class IndicateurImpactController extends AbstractController
{
    // LISTE (READ ALL)
    #[Route('/', name: 'app_indicateur_impact_index', methods: ['GET'])]
    public function index(IndicateurImpactRepository $repository): Response
    {
        $indicateurs = $repository->findAll();
        
        return $this->render('indicateur_impact/index.html.twig', [
            'indicateurs' => $indicateurs,
        ]);
    }

    // AJOUTER (CREATE)
    #[Route('/new', name: 'app_indicateur_impact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $indicateur = new IndicateurImpact();
        $form = $this->createForm(IndicateurImpactType::class, $indicateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($indicateur);
            $entityManager->flush();

            $this->addFlash('success', 'Indicateur d\'impact ajouté avec succès !');
            return $this->redirectToRoute('app_indicateur_impact_index');
        }

        return $this->render('indicateur_impact/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // DÉTAILS (READ ONE)
    #[Route('/{id}', name: 'app_indicateur_impact_show', methods: ['GET'])]
    public function show(IndicateurImpact $indicateur): Response
    {
        return $this->render('indicateur_impact/show.html.twig', [
            'indicateur' => $indicateur,
        ]);
    }

    // MODIFIER (UPDATE)
    #[Route('/{id}/edit', name: 'app_indicateur_impact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IndicateurImpact $indicateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IndicateurImpactType::class, $indicateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Indicateur d\'impact modifié avec succès !');
            return $this->redirectToRoute('app_indicateur_impact_index');
        }

        return $this->render('indicateur_impact/edit.html.twig', [
            'form' => $form->createView(),
            'indicateur' => $indicateur,
        ]);
    }

    // SUPPRIMER (DELETE)
    #[Route('/{id}/delete', name: 'app_indicateur_impact_delete', methods: ['POST'])]
    public function delete(Request $request, IndicateurImpact $indicateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indicateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($indicateur);
            $entityManager->flush();

            $this->addFlash('success', 'Indicateur d\'impact supprimé avec succès !');
        }

        return $this->redirectToRoute('app_indicateur_impact_index');
    }
}