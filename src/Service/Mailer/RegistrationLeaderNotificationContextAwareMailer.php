<?php

namespace App\Service\Mailer;

use App\Entity\EventParticipant;
use App\Repository\LeaderRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface as Mailer;
use Symfony\Component\Mime\Email;

final class RegistrationLeaderNotificationContextAwareMailer extends AbstractContextAwareMailer
{
    /**
     * This array will contain the KEY names that the context will require and the VALUE will be the object type that the context should have.
     */
    private const CONTEXT_REQUIREMENTS = [
        self::CONTEXT_REGISTRATION_OBJECT => EventParticipant::class,
    ];

    const CONTEXT_REGISTRATION_OBJECT = 'registration';

    public function __construct(
        Mailer $mailer,
        LoggerInterface $logger,
        private LeaderRepository $leaderRepository,
    ){
        parent::__construct($mailer, $logger);
    }

    /**
     * @inheritDoc
     */
    protected function configureEmail(TemplatedEmail|Email $email): TemplatedEmail|Email
    {
        assert($email instanceof TemplatedEmail);
        $email
            ->subject('Registration for Encounter')
            ->htmlTemplate('email/registration/notification.html.twig')
        ;

        if (array_key_exists(self::CONTEXT_REGISTRATION_OBJECT,$email->getContext())) {
            $registration = $email->getContext()[self::CONTEXT_REGISTRATION_OBJECT];
            assert($registration instanceof EventParticipant);
            $event = $registration->getEvent();

            //Create a more detailed subject line
            $email->subject(sprintf(
                '%s Registration for %s',
                ucfirst($registration->isServer() ? EventParticipant::TYPE_SERVER : EventParticipant::TYPE_ATTENDEE),
                $event->getName() ?? 'Registration for Encounter'
            ));
        }


        $toEmails = $this->leaderRepository->findAllLeadersWithNotificationOnAndActive();
        $email->to(...$this->createToAddresses($toEmails));

        return $email;
    }


}