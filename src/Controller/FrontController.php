<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $events = $evenementRepository->findBy([], ['dateHeure' => 'DESC']);
        return $this->render('front/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/organisateur/proposer-action', name: 'app_front_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement(); 
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            $this->addFlash('success', 'Événement ajouté avec succès !');
            
            return $this->redirectToRoute('app_organisateur_index', [
                'org' => $evenement->getNomOrganisateur()
            ]);
        }

        return $this->render('front/evenement_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/participer/{id}', name: 'app_participer_event', methods: ['POST'])]
    public function participer(int $id, Request $request, EvenementRepository $repo, EntityManagerInterface $em): Response
    {
        $event = $repo->find($id);
        $nomCitoyen = $request->request->get('nomCitoyen');

        if ($event && $nomCitoyen) {
            $participation = new Participation();
            $participation->setEvenement($event);
            $participation->setNomCitoyen($nomCitoyen);
            $participation->setDateInscription(new \DateTime()); 

            $em->persist($participation);
            $em->flush();

            // Na77ina el notifyAdmin houni bech n-na77ou el machakel mta3 el Mailer
            $this->addFlash('success', 'Félicitations ! Votre participation est confirmée.');
        } else {
            $this->addFlash('danger', 'Erreur lors de l\'inscription.');
        }

        return $this->redirectToRoute('app_front');
    }

    #[Route('/mes-actions', name: 'app_mes_actions')]
    public function mesActions(ParticipationRepository $participationRepository, Request $request): Response
    {
        $nomCitoyen = $request->query->get('nom'); 
        $mesParticipations = $nomCitoyen ? $participationRepository->findBy(['nomCitoyen' => $nomCitoyen]) : [];

        return $this->render('front/mes_actions.html.twig', [
            'participations' => $mesParticipations,
            'nom' => $nomCitoyen
        ]);
    }

    #[Route('/organisateur/mes-actions', name: 'app_organisateur_index')]
    public function organisateurIndex(EvenementRepository $repo, Request $request): Response
    {
        $nomOrg = $request->query->get('org');
        $events = $nomOrg ? $repo->findBy(['nomOrganisateur' => $nomOrg]) : [];

        return $this->render('front/organisateur_index.html.twig', [
            'evenements' => $events,
            'nomOrg' => $nomOrg
        ]);
    }

    #[Route('/organisateur/modifier/{id}', name: 'app_organisateur_edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Votre action a été modifiée !');
            return $this->redirectToRoute('app_organisateur_index', ['org' => $evenement->getNomOrganisateur()]);
        }

        return $this->render('front/organisateur_edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/organisateur/details/{id}', name: 'app_organisateur_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('front/organisateur_show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/organisateur/supprimer/{id}', name: 'app_organisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $nomOrg = $evenement->getNomOrganisateur();
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
            $this->addFlash('success', 'Événement supprimé !');
        }
        return $this->redirectToRoute('app_organisateur_index', ['org' => $nomOrg]);
    }

    #[Route('/meteo-details', name: 'app_meteo_details')]
    public function meteoDetails(): Response
    {
        return $this->render('front/meteo_details.html.twig');
    }

    #[Route('/mes-badges', name: 'app_mes_badges')]
    public function mesBadges(ParticipationRepository $participationRepository, Request $request): Response
    {
        $nomCitoyen = $request->query->get('nom'); 
        $mesParticipations = $nomCitoyen ? $participationRepository->findBy(['nomCitoyen' => $nomCitoyen]) : [];

        return $this->render('front/mes_badges.html.twig', [
            'participations' => $mesParticipations,
            'nom' => $nomCitoyen
        ]);
    }

    #[Route('/mes-actions/annuler/{id}', name: 'app_participation_annuler', methods: ['POST', 'GET'])]
    public function annulerParticipation(Participation $participation, EntityManagerInterface $entityManager): Response
    {
        $nom = $participation->getNomCitoyen();
        $entityManager->remove($participation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre participation a été annulée avec succès.');
        return $this->redirectToRoute('app_mes_actions', ['nom' => $nom]);
    }
}