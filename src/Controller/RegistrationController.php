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
use App\Form\ServerEventParticipantType;
use App\Repository\EventParticipantRepository;
use App\Repository\EventRepository;
use App\Service\Mailer\AttendeeRegistrationLeaderNotificationMailer;
use App\Service\Mailer\AttendeeRegistrationThankYouMailer;
use App\Service\PersonManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private PersonManager $personManager,
        private EventParticipantRepository $eventParticipantRepository,
        private AttendeeRegistrationLeaderNotificationMailer $registrationNotificationMailer,
        private AttendeeRegistrationThankYouMailer $registrationThankYouMailer,
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
        $eventRegistration = new EventParticipant();
        $eventRegistration->setEvent($event);
        $form = $this->createForm(AttendeeEventParticipantType::class,$eventRegistration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EventParticipant $eventRegistration */
//            $eventRegistration = $form->getData();
            $eventRegistration->setPerson(
                $this->personManager->exists(
                    $form->get('person')->getData()
                )
            );

//            $eventRegistration->setEvent($event);

            $this->eventParticipantRepository->save(
                $eventRegistration,
                true
            );

            //send email notification and thank you
            $this->sendEmails($eventRegistration);

            return $this->redirectToRoute('app_registration_registrationthankyou');
        }

        return $this->render('frontend/events/attendee.regestration.html.twig',[
            'event' => $event,
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/register/{event}/server', name: 'app_registration_server_formentry')]
    public function serverRegistration(Event $event,Request $request)
    {
        $eventRegistration = new EventParticipant();
        $eventRegistration->setEvent($event);
        $form = $this->createForm(ServerEventParticipantType::class,$eventRegistration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EventParticipant $eventRegistration */
            $eventRegistration->setPerson(
                $this->personManager->exists(
                    $form->get('person')->getData()
                )
            );

            $this->eventParticipantRepository->save(
                $eventRegistration,
                true
            );

            //send email notification and thank you
            $this->sendEmails($eventRegistration);

            return $this->redirectToRoute('app_registration_registrationthankyou');
        }

        return $this->render('frontend/events/server.regestration.html.twig',[
            'event' => $event,
            'form' => $form->createView(),
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/register/thank-you', name: 'app_registration_registrationthankyou')]
    public function registrationThankYou()
    {
        return $this->render('frontend/events/submitted.regestration.html.twig',[]);
    }

    protected function sendEmails(EventParticipant $registration)
    {

        $toEmail = [new Address($registration->getPerson()->getEmail(),$registration->getFullName())];
        $this->registrationThankYouMailer->send(
            toEmails: $toEmail,context: ['registration' => $registration],
        );
        $this->registrationNotificationMailer->send(
            context: ['registration' => $registration]
        );
    }
}