<?php

namespace App\Controller;

use App\Form\EventSearchType;
use App\Form\Model\EventSearch;
use App\Service\EventApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/events', name: 'events_')]
class EventController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET', 'POST'])]
    public function list(Request $request, EventApiService $eventApiService): Response
    {
        $events = $eventApiService->search();

        $eventSearch = new EventSearch();

        $eventSearchForm = $this->createForm(EventSearchType::class, $eventSearch);

        $eventSearchForm->handleRequest($request);

        if ($eventSearchForm->isSubmitted() && $eventSearchForm->isValid()) {

//            $eventSearch->setStartDate($eventSearchForm->get('startDate')->getData());
//            $eventSearch->setCity($eventSearchForm->get('city')->getData());

            $events = $eventApiService->search($eventSearch);
        }

        return $this->render('event/list.html.twig', [
            'events' => $events['records'],
            'eventForm' => $eventSearchForm
        ]);
    }
}
