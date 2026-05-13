<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/participation')]
final class ParticipationController extends AbstractController
{
    #[Route(name: 'app_participation_index', methods: ['GET'])]
    public function index(Request $request, ParticipationRepository $participationRepository): Response
    {
        $searchTerm = $request->query->get('q');
        $queryBuilder = $participationRepository->createQueryBuilder('p');

        if ($searchTerm) {
            $queryBuilder->andWhere('p.nomCitoyen LIKE :term')
                         ->setParameter('term', '%' . $searchTerm . '%');
        }

        $queryBuilder->orderBy('p.dateInscription', 'DESC');

        return $this->render('participation/index.html.twig', [
            'participations' => $queryBuilder->getQuery()->getResult(),
        ]);
    }

    #[Route('/new', name: 'app_participation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EvenementRepository $evenementRepository): Response 
    {
        if ($request->isMethod('POST')) {
            $nomCitoyen = $request->request->get('nomCitoyen');
            $eventId = $request->request->get('event_id') ?? $request->request->all('participation')['evenement'] ?? null;

            if ($nomCitoyen && $eventId) {
                $evenement = $evenementRepository->find($eventId);
                if ($evenement) {
                    $participation = new Participation();
                    $participation->setNomCitoyen($nomCitoyen);
                    $participation->setEvenement($evenement);
                    $participation->setDateInscription(new \DateTime());

                    $entityManager->persist($participation);
                    $entityManager->flush();

                    // Na77ina el notifyAdmin houni
                    $this->addFlash('success', 'Inscription réussie !');
                    
                    return $request->request->has('event_id') ? $this->redirectToRoute('app_front') : $this->redirectToRoute('app_participation_index');
                }
            }
        }

        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participation);
            $entityManager->flush();
            return $this->redirectToRoute('app_participation_index');
        }

        return $this->render('participation/new.html.twig', [
            'participation' => $participation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Na77ina el notifyAdmin houni
            $this->addFlash('success', 'Modification avec succès !');
            return $this->redirectToRoute('app_participation_index');
        }

        return $this->render('participation/edit.html.twig', [
            'participation' => $participation,
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/{id}', name: 'app_participation_delete', methods: ['POST'])]
    public function delete(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($participation);
            $entityManager->flush();

            // Na77ina el notifyAdmin houni
            $this->addFlash('danger', 'Participation supprimée.');
        }

        return $this->redirectToRoute('app_participation_index');
    }

    #[Route('/{id}', name: 'app_participation_show', methods: ['GET'])]
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }
}