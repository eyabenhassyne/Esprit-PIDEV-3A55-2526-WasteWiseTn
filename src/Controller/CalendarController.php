<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class CalendarController extends AbstractController
{
     #[Route('/calendar', name: 'app_calendar', methods: ['GET'])]
     public function index(): Response
     {
    
        return $this->render('calendar/index.html.twig');
     }

    #[Route('/fc-load-events', name: 'fc_load_events', methods: ['GET'])]
    public function loadEvents(EvenementRepository $repo, Request $request): JsonResponse
    {
        try {
            
            $events = $repo->findAll();
            $data = [];

            foreach ($events as $e) {
                if ($e->getDateHeure()) {
                    $data[] = [
                        'id'    => $e->getId(),
                        'title' => (string) $e->getTitle(), 
                        'start' => $e->getDateHeure()->format('Y-m-d'), 
                        'allDay' => true,
                        'backgroundColor' => '#2f6b4f',
                        'borderColor'     => '#2f6b4f',
                        'textColor'       => '#ffffff',
                        'url' => $this->generateUrl('app_evenement_show', ['id' => $e->getId()]),
                    ];
                }
            }

            return new JsonResponse($data);

        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 500);
        }
    }
}