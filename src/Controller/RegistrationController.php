<?php
/**
 * @Author: jwamser
 * @CreateAt: 6/19/23
 * Project: EncounterTheCross
 * File Name: RegistrationController.php
 */

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventParticipant;
use App\Form\AttendeeEventParticipantType;
use App\Repository\EventParticipantRepository;
use App\Repository\EventRepository;
use App\Service\PersonManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private PersonManager $personManager,
        private EventParticipantRepository $eventParticipantRepository
    ){
    }

    #[Route('/register', name: 'app_registration_list')]
    public function encounterList(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        return $this->render('frontend/events/list.html.twig',[
            'events' => $events,
        ]);
    }

    #[Route('/register/{event}/attendee', name: 'app_registration_attendee_formentry')]
    public function attendeeRegistration(Event $event,Request $request)
    {
        dump($event);

        $form = $this->createForm(AttendeeEventParticipantType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EventParticipant $eventRegistration */
            $eventRegistration = $form->getData();
            $eventRegistration->setPerson(
                $this->personManager->exists(
                    $form->get('person')->getData()
                )
            );

            $eventRegistration->setEvent($event);

            $this->eventParticipantRepository->save(
                $eventRegistration,
                true
            );
            return $this->redirectToRoute('app_registration_registrationthankyou');
        }

        return $this->render('frontend/events/attendee.regestration.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/thank-you', name: 'app_registration_registrationthankyou')]
    public function registrationThankYou()
    {
        return $this->render('frontend/events/submitted.regestration.html.twig',[]);
    }
}