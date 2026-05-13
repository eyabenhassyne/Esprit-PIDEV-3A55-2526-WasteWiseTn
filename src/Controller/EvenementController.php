<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evenement')]
final class EvenementController extends AbstractController
{
    #[Route('', name: 'app_evenement_index', methods: ['GET'])]
    public function index(Request $request, EvenementRepository $evenementRepository): Response
    {
        $searchTerm = $request->query->get('q');
        $orgName = $request->query->get('org'); 
        $sortBy = $request->query->get('sort', 'dateHeure'); 
        $direction = $request->query->get('direction', 'DESC'); 

        $queryBuilder = $evenementRepository->createQueryBuilder('e');

        if ($searchTerm) {
            $queryBuilder->andWhere('e.title LIKE :term')
                         ->setParameter('term', '%'.$searchTerm.'%');
        }

        if ($orgName) {
            $queryBuilder->andWhere('e.nomOrganisateur LIKE :org')
                         ->setParameter('org', '%'.$orgName.'%');
        }

        if (in_array($sortBy, ['title', 'dateHeure', 'nomOrganisateur'])) {
            $queryBuilder->orderBy('e.' . $sortBy, $direction);
        }

        $evenements = $queryBuilder->getQuery()->getResult();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', 'Événement créé avec succès !');
            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Modification réussie !');
            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();

            $this->addFlash('danger', 'Événement supprimé !');
        }

        return $this->redirectToRoute('app_evenement_index');
    }

    public function predictAttendance($event, $weatherTemp) {
        $baseScore = 50; 

        if (str_contains(strtolower($event->getLieu()), 'tunis')) {
            $baseScore += 20;
        }

        if ($weatherTemp >= 15 && $weatherTemp <= 25) {
            $baseScore += 30;
        } elseif ($weatherTemp < 10) {
            $baseScore -= 15; 
        }

        return $baseScore;
    }
}