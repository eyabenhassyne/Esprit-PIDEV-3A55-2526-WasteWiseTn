<?php

namespace App\EventSubscriber;

use App\Repository\EvenementRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private EvenementRepository $evenementRepository;
    private UrlGeneratorInterface $router;

    public function __construct(EvenementRepository $repo, UrlGeneratorInterface $router)
    {
        $this->evenementRepository = $repo;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Thabbet houni: Symfony baddlet l-ism f-el versions jdod
            'calendar.set_data' => 'onCalendarSetData', 
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar): void
    {
        // PHPStan y7eb i-chouf el return type (: void)
        
        $evenements = $this->evenementRepository->findAll();

        foreach ($evenements as $ev) {
            
            // Thabbet elli el Title mahouch null bech PHPStan ma yzammarch
            $title = $ev->getTitle() ?? 'Sans titre';
            $date = $ev->getDateHeure();

            if (!$date) {
                continue; // Itha mafammach date, ma n-zidouch lel calendar
            }

            $eventCalendar = new Event(
                $title, 
                $date 
            );

            if (method_exists($ev, 'getDateFin') && $ev->getDateFin()) {
                $eventCalendar->setEnd($ev->getDateFin());
            }

            $eventCalendar->setOptions([
                'backgroundColor' => '#2f6b4f',
                'borderColor' => '#2f6b4f',
                'textColor' => 'white',
            ]);
            
            $eventCalendar->addOption('url', $this->router->generate('app_evenement_show', [
                'id' => $ev->getId(),
            ]));

            $calendar->addEvent($eventCalendar);
        }
    }
}