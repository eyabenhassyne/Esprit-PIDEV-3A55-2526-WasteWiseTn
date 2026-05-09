<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 

class NotificationAdminController extends AbstractController
{
    /**
     * @Route("/admin/notifications", name="app_notifications")
     */
    #[Route('/notifications', name: 'app_notifications')]
    public function index(NotificationRepository $repo): Response
    {
        return $this->render('notifications.html.twig', [
            'notifications' => $repo->findAll(),
        ]);
    }
}