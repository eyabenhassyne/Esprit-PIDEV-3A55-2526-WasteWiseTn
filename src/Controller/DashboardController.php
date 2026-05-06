<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_dashboard_admin');
        }

        if ($this->isGranted('ROLE_VALORIZER')) {
            return $this->redirectToRoute('app_dashboard_valorizateur');
        }

        return $this->redirectToRoute('app_dashboard_citoyen');
    }

    #[Route('/dashboard/citoyen', name: 'app_dashboard_citoyen', methods: ['GET'])]
    public function citoyen(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('dashboard/citoyen.html.twig');
    }

    #[Route('/dashboard/admin', name: 'app_dashboard_admin', methods: ['GET'])]
    public function admin(UserRepository $userRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('dashboard/admin.html.twig', [
            'usersTotal' => $userRepo->count([]),
            'lastUsers' => $userRepo->findBy([], ['createdAt' => 'DESC'], 5),
        ]);
    }

    #[Route('/dashboard/valorisateur', name: 'app_dashboard_valorizateur', methods: ['GET'])]
    public function valorisateur(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_VALORIZER');

        return $this->render('dashboard/valorisateur.html.twig');
    }
}